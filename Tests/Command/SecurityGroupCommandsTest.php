<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use Guzzle\Rs\Model\SecurityGroup;

class SecurityGroupCommandsTest extends ClientCommandsBase {
	
	/**
	 * 
	 * @var SecurityGroup
	 */
	protected $_security_group;
	
	protected function setUp() {
		parent::setUp();
		$this->_security_group = new SecurityGroup();
		$this->_security_group->aws_group_name = "Guzzle_Test_$this->_testTs";
		$this->_security_group->aws_description = "Description";
		$this->_security_group->create();
	}
	
	protected function tearDown() {
		$this->_security_group->destroy();
	}

	public function testCanGetSecurityGroupByIdJson() {
		$cmd = $this->_client->getCommand('ec2_security_group', array('id' => $this->_security_group->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		print $resp->getResponse();
		
		$this->assertEquals($this->_security_group->aws_group_name, $result->aws_group_name);
	}
	
}

?>