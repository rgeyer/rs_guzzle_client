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
		
		$this->_deployment = new Deployment();
		$this->_deployment->nickname = "Guzzle_Test_For_Servers_$this->_testTs";
		$this->_deployment->description = 'described';
		$this->_deployment->create();
		
		$this->_security_group = new SecurityGroup();
		$this->_security_group->aws_group_name = "Guzzle_Test_For_Servers_$this->_testTs";
		$this->_security_group->aws_description = "described";
		$this->_security_group->create();		 
		
		$result = $this->executeCommand('ec2_server_templates');

		$result_obj = json_decode($result->getBody(true));		
		
		$this->_serverTemplateHref = $result_obj[0]->href;
		
		$baseStForLinux = null;
		$baseStForWindows = null;
		foreach($result_obj as $st) {
			if($st->nickname == "Base ServerTemplate for Linux") { $baseStForLinux = $st; }
			if($st->nickname == "Base ServerTemplate for Windows") { $baseStForWindows = $st; }
		}
		
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
		
		# No need to delete the server(s) this contains.
		$this->_deployment->destroy();	
	
		$this->_ssh_key->destroy();
		
		$this->_security_group->destroy();
		
		parent::tearDown();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
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
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs")),
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
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs", "state=stopped")),
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
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs"), 'output_format' => '.xml'),
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
			array('filter' => array("nickname=Guzzle_Test_$this->_testTs", "state=stopped"), 'output_format' => '.xml'),
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
		$result = $this->executeCommand('server', array('id' => $this->_server->id), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('Guzzle\Rs\Model\Server', $result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $result->nickname);		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetServersByIdXml() {
		$command = null;
		$result = $this->executeCommand('server', array('id' => $this->_server->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('Guzzle\Rs\Model\Server', $result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $result->nickname);		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
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
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetSettingsOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_settings', array('id' => $this->_server->id), &$command);
				
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
		$result = $this->executeCommand('servers_settings', array('id' => $this->_server->id, 'output_format' => '.xml'), &$command);
				
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetAlertSpecsOfServerJson() {
		$command = null;
		$result = $this->executeCommand('servers_alert_specs', array('id' => $this->_server->id), &$command);
		
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
		$result = $this->executeCommand('servers_alert_specs', array('id' => $this->_server->id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
}

?>