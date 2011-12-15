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
	}
	
	protected function tearDown() {
		$this->_ssh_key->destroy();
		
		$this->_deployment->destroy();
		
		$this->_security_group->destroy();
		
		parent::tearDown();
	}
	
	public function testCanCreateServer() {
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
}

?>