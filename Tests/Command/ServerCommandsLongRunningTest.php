<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Model\SecurityGroup;

use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Model\Server;
use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Model\ServerTemplate;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerCommandsLongRunningTest extends ClientCommandsBase {
	
	/**
	 * 
	 * @var SshKey
	 */
	protected static $_ssh_key;	
	
	/**
	 * 
	 * @var Deployment
	 */
	protected static $_deployment;
	
	/**
	 * 
	 * @var SecurityGroup
	 */
	protected static $_security_group;
	
	protected static $_serverTemplateHref;
	
	protected static $_server;
	
	protected static $_server_started;
	
	protected static $_server_to_start;
	
	protected static $_server_ebs_started;
	
	protected static $_server_ebs_stopped;
	
	protected static $testTs;
	
	protected static function waitForServersToReachState(array $servers, $state) {
		do {
			$keep_it_rolling = false;
			foreach($servers as $server) {
				$server->find_by_id($server->id);
				if($server->state != $state) {
					$keep_it_rolling = true;
				}
			}
			sleep(10);
		} while ($keep_it_rolling);
	}
	
	public static function setUpBeforeClass() {
		self::$testTs = time();				
		self::$_ssh_key = new SshKey(); 
		self::$_ssh_key->aws_key_name = "Guzzle_Test_For_Servers_Long_Running_" . self::$testTs;
		self::$_ssh_key->create();
		
		self::$_deployment = new Deployment();
		self::$_deployment->nickname = "Guzzle_Test_For_Servers_Long_Running_" . self::$testTs;
		self::$_deployment->description = 'described';
		self::$_deployment->create();
		
		self::$_security_group = new SecurityGroup();
		self::$_security_group->aws_group_name = "Guzzle_Test_For_Servers_Long_Running_" . self::$testTs;
		self::$_security_group->aws_description = "described";
		self::$_security_group->create();		 
		
		$st = new ServerTemplate();
		$result_obj = $st->index();
		
		#$result = $this->executeCommand('server_templates');
		#$result_obj = json_decode($result->getBody(true));		
		
		self::$_serverTemplateHref = $result_obj[0]->href;
		
		$baseStForLinux = null;
		$baseStForWindows = null;
		foreach($result_obj as $st) {
			if($st->nickname == "Base ServerTemplate for Linux") { $baseStForLinux = $st; }
			if($st->nickname == "Base ServerTemplate for Linux (EBS)") { $baseStForWindows = $st; }
		}
		
		$params = array(
				'server[nickname]' => "Guzzle_Test_" . self::$testTs,
				'server[server_template_href]' => self::$_serverTemplateHref,
				'server[ec2_ssh_key_href]' => self::$_ssh_key->href,
				'server[ec2_security_groups_href]' => array(self::$_security_group->href),
				'server[deployment_href]' => self::$_deployment->href
		);
		self::$_server = new Server();
		self::$_server->create($params);
		
		$params['server[server_template_href]'] = $baseStForLinux->href;
		self::$_server_to_start = new Server();
		self::$_server_to_start->create($params);
		
		self::$_server_started = new Server();
		self::$_server_started->create($params);
		self::$_server_started->start();		
		
		$params['server[server_template_href]'] = $baseStForWindows->href;
		self::$_server_ebs_started = new Server();
		self::$_server_ebs_started->create($params);
		self::$_server_ebs_started->start();
		
		self::$_server_ebs_stopped = new Server();
		self::$_server_ebs_stopped->create($params);
		self::$_server_ebs_stopped->start();
		
		# Wait for _server_ebs_started and _server_ebs_stopped to finish starting
		$wait_on_these = array(self::$_server_started, self::$_server_ebs_started, self::$_server_ebs_stopped);
		self::waitForServersToReachState($wait_on_these, 'operational');
		
		self::$_server_ebs_stopped->stop_ebs();
		self::waitForServersToReachState(array(self::$_server_ebs_stopped), 'stopped');
	}
	
	public static function tearDownAfterClass() {
		
		# Wait for _server_ebs_started and _server_ebs_stopped to finish starting
		$wait_on_these = array(self::$_server_to_start, self::$_server_started, self::$_server_ebs_started, self::$_server_ebs_stopped);
		foreach($wait_on_these as $server) {
			$server->stop(true);
		}
		self::waitForServersToReachState($wait_on_these, 'stopped');
		
		# No need to delete the server(s) this contains.
		self::$_deployment->destroy();	
	
		self::$_ssh_key->destroy();
		
		self::$_security_group->destroy();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanStartServer() {
		$command = null;
		$result = $this->executeCommand('servers_start', array('id' => self::$_server_to_start->id), &$command);

		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertEquals(self::$_server_to_start->href, $result->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanStopEbsBackedServer() {
		$command = null;
		$result = $this->executeCommand('servers_stop_ebs', array('id' => self::$_server_ebs_started->id), &$command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($result->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanStartStoppedEbsBackedServer() {
		$command = null;
		$result = $this->executeCommand('servers_start_ebs', array('id' => self::$_server_ebs_stopped->id), &$command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($result->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanLockServer() {
		$command = null;
		$result = $this->executeCommand('servers_update', array('id' => self::$_server_started->id, 'server[lock]' => 'true'), &$command, 'lock');
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		$this->assertEquals(true, self::$_server_started->settings()->locked);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanUnLockServer() {
		$command = null;
		$result = $this->executeCommand('servers_update', array('id' => self::$_server_started->id, 'server[lock]' => 'false'), &$command, 'unlock');
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		$this->assertEquals(false, self::$_server_started->settings()->locked);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanRebootServer() {
		$command = null;
		$result = $this->executeCommand('servers_reboot', array('id' => self::$_server_started->id), &$command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertEquals(self::$_server_started->href, $result->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanRunScriptOnServer() {
		$this->markTestIncomplete("Need to know a script id");
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanExecuteRecipeOnServer() {
		$this->markTestIncomplete("Need to have a ServerTemplate with a recipe");
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */	
	public function testCanAttachVolumeToServer() {
		$this->markTestIncomplete("Need to create a volume first");
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetSketchyDataOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_get_sketchy_data', array('id' => self::$_server_started->id, 'start' => 1, 'end' => 10, 'plugin_name' => 'cpu-0', 'plugin_type' => 'cpu-idle'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetSketchyDataOfServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_get_sketchy_data', array('id' => self::$_server_started->id, 'start' => 1, 'end' => 10, 'plugin_name' => 'cpu-0', 'plugin_type' => 'cpu-idle', 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanShowCurrentServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_current_show', array('id' => self::$_server_started->id), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$result = $json_obj = json_decode($result->getBody(true));
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $result->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanShowCurrentServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_current_show', array('id' => self::$_server_started->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $result->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanUpdateCurrentServer() {
		$server = new Server();
		$server->find_by_id(self::$_server_started->id);
		
		$settings = $server->current_show(); 
		$params = $settings->parameters;
		$tz = '';
		foreach($params as $param) {
			if($param->name == 'SYS_TZINFO') { $tz = $param->value; }
		}
		$this->assertEquals('text:UTC', $tz);
		
		$command = null;
		$result = $this->executeCommand('servers_current_update', array('id' => self::$_server_started->id, 'server[parameters]' => array('SYS_TZINFO' => 'text:PST')), &$command);
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$server->find_by_id(self::$_server_started->id);
		$params = $server->current_show()->parameters;
		$tz = '';
		foreach($params as $param) {
			if($param->name == 'SYS_TZINFO') { $tz = $param->value; }
		}
		$this->assertEquals('text:PST', $tz);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetSettingsForCurrentServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_current_settings', array('id' => self::$_server_started->id), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetSettingsForCurrentServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_current_settings', array('id' => self::$_server_started->id, 'output_format' => '.xml'), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetMonitorsOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_monitoring', array('id' => self::$_server_started->id), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetMonitorsOfServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_monitoring', array('id' => self::$_server_started->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$malformedXml = $result->getBody(true);
		libxml_use_internal_errors(true);
		$sxml = simplexml_load_string($malformedXml);
		$this->assertGreaterThan(0, count(libxml_get_errors()));
		libxml_clear_errors();
		libxml_use_internal_errors(false);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetSpecificMonitorOfServerJson() {
		$params = array('id' => self::$_server_started->id, 'graph_name' => 'cpu-0/cpu-idle', 'size' => 'tiny', 'period' => 'now', 'timezone' => 'UTC');
		$command = null;
		$result = $this->executeCommand('servers_monitoring_graph_name', $params, &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertNotNull($json_obj->monitor->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanGetSpecificMonitorOfServerXml() {
		$params = array('id' => self::$_server_started->id, 'graph_name' => 'cpu-0/cpu-idle', 'size' => 'tiny', 'period' => 'now', 'timezone' => 'UTC', 'output_format' => '.xml');
		$command = null;
		$result = $this->executeCommand('servers_monitoring_graph_name', $params, &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$malformedXml = $result->getBody(true);
		libxml_use_internal_errors(true);
		$sxml = simplexml_load_string($malformedXml);
		$this->assertGreaterThan(0, count(libxml_get_errors()));
		libxml_clear_errors();
		libxml_use_internal_errors(false);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanStopServer() {
		$command = null;
		$result = $this->executeCommand('servers_stop', array('id' => self::$_server_started->id), &$command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertEquals(self::$_server_started->href, $result->href);
	}
}

?>