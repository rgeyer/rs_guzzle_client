<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Tests\Utils\RequestFactory;
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
		
		$cmd = $this->_client->getCommand('server_templates');
		$resp = $cmd->execute();
		$result = $cmd->getResult();

		$result_obj = json_decode($result->getBody(true));		
		
		$this->_serverTemplateHref = $result_obj[0]->href;
	}
	
	protected function tearDown() {
		$this->_ssh_key->destroy();
		
		$this->_deployment->destroy();
		
		parent::tearDown();
	}
	
	public function testCanCreateServer() {
		$params = array(
			'server[nickname]' => null,
			'server[server_template_href]' => null,
			'server[ec2_ssh_key_href]' => null,
			'server[ec2_security_groups_href]' => null,
			'server[deployment_href]' => null
		);
		$cmd = $this->_client->getCommand('servers_create');		
	}
}

?>