<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SshKeyCommandsTest extends ClientCommandsBase {
	
	protected $_ssh_key_id;
	
	protected function setUp() {
		parent::setUp();
		
		$key = $this->executeCommand('ec2_ssh_keys_create', array('ec2_ssh_key[aws_key_name]' => "Guzzle_Test_$this->_testTs"));
		
		$this->_ssh_key_id = $key->id;
	}
	
	protected function tearDown() {		
		$this->executeCommand('ec2_ssh_keys_destroy', array('id' => $this->_ssh_key_id));

		parent::tearDown();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowAKey() {
		$result = $this->executeCommand('ec2_ssh_key', array('id' => $this->_ssh_key_id));
				
		$this->assertEquals("Guzzle_Test_$this->_testTs", $result->aws_key_name);
	}
	
}

?>