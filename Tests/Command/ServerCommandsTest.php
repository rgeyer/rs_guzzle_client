<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Model\SecurityGroup;

use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Model\Server;
use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerCommandsTest extends ClientCommandsBase {
	
	/**
	 * 
	 * @var SshKey
	 */
	protected $_ssh_key;	
	
	/**
	 * 
	 * @var Deployment
	 */
	protected $_deployment;
	
	/**
	 * 
	 * @var SecurityGroup
	 */
	protected $_security_group;
	
	protected $_serverTemplateHref;
	
	protected $_server;
	
	protected function setUp() {
		parent::setUp();
		
		$this->_ssh_key = new SshKey(); 
		$this->_ssh_key->aws_key_name = "Guzzle_Test_For_Servers_$this->_testTs";
		$this->_ssh_key->create();
		
		$this->_ssh_key_id = $this->_ssh_key->id;
		
		$this->_deployment = new Deployment();
		$this->_deployment->nickname = "Guzzle_Test_For_Servers_$this->_testTs";
		$this->_deployment->description = 'described';
		$this->_deployment->create();
		
		$this->_security_group = new SecurityGroup();
		$this->_security_group->aws_group_name = "Guzzle_Test_For_Servers_$this->_testTs";
		$this->_security_group->aws_description = "described";
		$this->_security_group->create();		 
		
		$result = $this->executeCommand('server_templates');

		$result_obj = json_decode($result->getBody(true));		
		
		$this->_serverTemplateHref = $result_obj[0]->href;
		
		$params = array(
				'server[nickname]' => "Guzzle_Test_$this->_testTs",
				'server[server_template_href]' => $this->_serverTemplateHref,
				'server[ec2_ssh_key_href]' => $this->_ssh_key->href,
				'server[ec2_security_groups_href]' => array($this->_security_group->href),
				'server[deployment_href]' => $this->_deployment->href
		);
		$this->_server = new Server();
		$this->_server->create($params);
		
	}
	
	protected function tearDown() {
		$this->_ssh_key->destroy();
		
		# No need to delete the server(s) this contains.
		$this->_deployment->destroy();
		
		$this->_security_group->destroy();
		
		parent::tearDown();
	}
	
	public function testCanCreateAndDestroyOneServer() {
		$command = null;
		$params = array(
			'server[nickname]' => "Guzzle_Test_$this->_testTs",
			'server[server_template_href]' => $this->_serverTemplateHref,
			'server[ec2_ssh_key_href]' => $this->_ssh_key->href,
			'server[ec2_security_groups_href]' => array($this->_security_group->href),
			'server[deployment_href]' => $this->_deployment->href
		);
		$result = $this->executeCommand('servers_create', $params, &$command);

		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$result = $this->executeCommand('servers_destroy', array('id' => $result->id));
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	public function testCanListAllServersJson() {
		$result = $this->executeCommand('servers');
		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertGreaterThan(0, count($json_obj));		
	}
	
	public function testCanListAllServersXml() {
		$command = null;
		$result = $this->executeCommand('servers', array('output_format' => '.xml'), &$command);
						
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result));		
	}
	
	public function testCanListAllServersWithOneFilterJson() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs")),
			&$command,
			'with_one_filter'
		);
		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));		
	}
	
	public function testCanListAllServersWithTwoFiltersJson() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs", "state=stopped")),
			&$command,
			'with_two_filters'
		);
		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));		
	}
	
	public function testCanListAllServersWithOneFilterXml() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs"), 'output_format' => '.xml'),
			&$command,
			'with_one_filter'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals(1, count($result));		
	}
	
	public function testCanListAllServersWithTwoFiltersXml() {
		$command = null;
		$result = $this->executeCommand('servers',
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs", "state=stopped"), 'output_format' => '.xml'),
			&$command,
			'with_two_filters'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals(1, count($result));		
	}
	
	public function testCanGetServersByIdJson() {
		$command = null;
		$result = $this->executeCommand('server', array('id' => $this->_server->id), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('Guzzle\Rs\Model\Server', $result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $result->nickname);		
	}
	
	public function testCanGetServersByIdXml() {
		$command = null;
		$result = $this->executeCommand('server', array('id' => $this->_server->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('Guzzle\Rs\Model\Server', $result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $result->nickname);		
	}
	
	public function testCanUpdateServerNickname() {
		$server = new Server();
		$server->find_by_id($this->_server->id);
		
		$this->assertEquals("Guzzle_Test_$this->_testTs", $server->nickname);
		
		$command = null;
		$result = $this->executeCommand('servers_update', array('id' => $this->_server->id, 'server[nickname]' => "Guzzle_Changed_$this->_testTs"), &$command);
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$server->find_by_id($this->_server->id);
		
		$this->assertEquals("Guzzle_Changed_$this->_testTs", $server->nickname);
	}
	
	public function testCanStartServer() {
		$this->markTestIncomplete("Need to use a known ServerTemplate with required parameters");
		/*$command = null;
		$result = $this->executeCommand('servers_start', array('id' => $this->_server->id));

		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertEquals($this->_server->href, $result->href);*/
	}
	
	public function testCanStopEbsBackedServer() {
		$this->markTestIncomplete("Need to have a started, running EBS backed server");
	}
	
	public function testCanStartStoppedEbsBackedServer() {
		$this->markTestIncomplete("Need to have a stopped EBS backed server");
	}
	
	public function testCanLockServer() {
		$this->markTestIncomplete("Would require starting a server, and waiting for it become operational before locking it");
	}
	
	public function testCanUnLockServer() {
		$this->markTestIncomplete("Would require starting a server, and waiting for it become operational before unlocking it");
	}
	
	public function testCanRebootServer() {
		$this->markTestIncomplete("Need to have a started, running server");
	}
	
	public function testCanStopServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanRunScriptOnServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanExecuteRecipeOnServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanAttachVolumeToServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanGetSettingsOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_settings', array('id' => $this->_server->id), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	public function testCanGetSettingsOfServerXml() {
		$command = null;
		$result = $this->executeCommand('servers_settings', array('id' => $this->_server->id, 'output_format' => '.xml'), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
	
	public function testCanGetSketchyDataOfServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanShowCurrentServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanUpdateCurrentServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanGetSettingsForCurrentServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanGetAlertSpecsOfServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanGetMonitorsOfServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
	
	public function testCanGetSpecificMonitorOfServer() {
		$this->markTestIncomplete("Need to have a started running server");
	}
}

?>