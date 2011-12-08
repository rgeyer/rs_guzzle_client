<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\RequestFactory;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SshKeyCommandsTest extends ClientCommandsBase {
	
	protected $_ssh_key_id;
	
	protected function setUp() {
		parent::setUp();
		
		$key = RequestFactory::createSshKey($this->_client, "Guzzle_Test_$this->_testTs");
		
		$this->_ssh_key_id = $key->id;
	}
	
	protected function tearDown() {		
		$cmd = $this->_client->getCommand('ec2_ssh_keys_destroy', array('id' => $this->_ssh_key_id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();

		parent::tearDown();
	}
	
	public function testCanShowAKey() {
		$cmd = $this->_client->getCommand('ec2_ssh_key', array('id' => $this->_ssh_key_id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
				
		$this->assertEquals("Guzzle_Test_$this->_testTs", $result->aws_key_name);
	}
	
}

?>