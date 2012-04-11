<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Model\SecurityGroup;

use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Model\Server;
use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	
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
	
	public static function setUpBeforeClass() {		
		$testClassToApproximateThis = new ServerCommandsTest();
		$testClassToApproximateThis->setUp();
		
		self::$testTs = time();		
		self::$_ssh_key = new SshKey(); 
		self::$_ssh_key->aws_key_name = "Guzzle_Test_For_Servers_" . self::$testTs;
		self::$_ssh_key->create();
		
		self::$_deployment = new Deployment();
		self::$_deployment->nickname = "Guzzle_Test_For_Servers_". self::$testTs;
		self::$_deployment->description = 'described';
		self::$_deployment->create();
		
		self::$_security_group = new SecurityGroup();
		self::$_security_group->aws_group_name = "Guzzle_Test_For_Servers_". self::$testTs;
		self::$_security_group->aws_description = "described";
		self::$_security_group->create();		 
		
		$result = $testClassToApproximateThis->executeCommand('ec2_server_templates');

		$result_obj = json_decode($result->getBody(true));		
		
		self::$_serverTemplateHref = $result_obj[0]->href;
		
		$baseStForLinux = null;
		$baseStForWindows = null;
		foreach($result_obj as $st) {
			if($st->nickname == "Base ServerTemplate for Linux") { $baseStForLinux = $st; }
			if($st->nickname == "Base ServerTemplate for Windows") { $baseStForWindows = $st; }
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
	}
	
	public static function tearDownAfterClass() {
		
		# No need to delete the server(s) this contains.
		self::$_deployment->destroy();	
	
		self::$_ssh_key->destroy();
		
		self::$_security_group->destroy();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateServer() {
		$command = null;
		$params = array(
			'server[nickname]' => "Guzzle_Test_". $this->_testTs,
			'server[server_template_href]' => self::$_serverTemplateHref,
			'server[ec2_ssh_key_href]' => self::$_ssh_key->href,
			'server[ec2_security_groups_href]' => array(self::$_security_group->href),
			'server[deployment_href]' => self::$_deployment->href
		);
		$result = $this->executeCommand('servers_create', $params, &$command);

		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));		
		
		return $this->getIdFromHref('servers', $command->getResponse()->getHeader('Location'));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateServer
	 */
	public function testCanDestroyServer($server_id) {
		$command = null;
		$result = $this->executeCommand('servers_destroy', array('id' => $server_id), &$command);
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServersJson() {
		$result = $this->executeCommand('servers');
		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertGreaterThan(0, count($json_obj));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServersXml() {
		$command = null;
		$result = $this->executeCommand('servers', array('output_format' => '.xml'), &$command);
						
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServersWithOneFilterJson() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_" . self::$testTs)),
			&$command,
			'with_one_filter'
		);
		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServersWithTwoFiltersJson() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_" . self::$testTs, "state=stopped")),
			&$command,
			'with_two_filters'
		);
		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServersWithOneFilterXml() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_" . self::$testTs), 'output_format' => '.xml'),
			&$command,
			'with_one_filter'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals(1, count($result));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServersWithTwoFiltersXml() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_" . self::$testTs, "state=stopped"), 'output_format' => '.xml'),
			&$command,
			'with_two_filters'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals(1, count($result));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetServersByIdJson() {
		$command = null;
		$result = $this->executeCommand('server', array('id' => self::$_server->id), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('Guzzle\Rs\Model\Server', $result);
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $result->nickname);		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetServersByIdXml() {
		$command = null;
		$result = $this->executeCommand('server', array('id' => self::$_server->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('Guzzle\Rs\Model\Server', $result);
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $result->nickname);		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateServerNickname() {
		$server = new Server();
		$server->find_by_id(self::$_server->id);
		
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $server->nickname);
		
		$command = null;
		$result = $this->executeCommand('servers_update', array('id' => self::$_server->id, 'server[nickname]' => "Guzzle_Changed_" . self::$testTs), &$command);
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$server->find_by_id(self::$_server->id);
		
		$this->assertEquals("Guzzle_Changed_" . self::$testTs, $server->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetSettingsOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_settings', array('id' => self::$_server->id), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetSettingsOfServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_settings', array('id' => self::$_server->id, 'output_format' => '.xml'), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetAlertSpecsOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_alert_specs', array('id' => self::$_server->id), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetAlertSpecsOfServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_alert_specs', array('id' => self::$_server->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
}

?>