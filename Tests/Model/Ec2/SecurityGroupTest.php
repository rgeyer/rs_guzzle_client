<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\Ec2\SecurityGroup;
use RGeyer\Guzzle\Rs\Model\AbstractSecurityGroup;

class SecurityGroupTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/login');
		ClientFactory::getClient()->get('login')->send();
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testExtendsAbstractSecurityGroup() {
    $secgrp = new SecurityGroup();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\AbstractSecurityGroup', $secgrp);
  }
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanAddACidrSecurityGroupPermission() {
		$this->setMockResponse(ClientFactory::getClient(), array(
			'1.0/ec2_security_group/js/response',
			'1.0/ec2_security_groups_update/add_cidr_one_rule/response'
		));
		$secgrp = new SecurityGroup();
		$secgrp->find_by_id(12345);
    $secgrp->createCidrRule('tcp', '0.0.0.0/0', 22, 22);
    $lastCommand = $secgrp->getLastCommand();
    $request = (string)$lastCommand->getRequest();

    $this->assertContains('ec2_security_group%5Bprotocol%5D=tcp', $request);
    $this->assertContains('ec2_security_group%5Bfrom_port%5D=22', $request);
    $this->assertContains('ec2_security_group%5Bto_port%5D=22', $request);
    $this->assertContains('ec2_security_group%5Bcidr_ips%5D=0.0.0.0%2F0', $request);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanAddACidrSecurityGroupPermissionSpecifyingOnlyOnePort() {
		$this->setMockResponse(ClientFactory::getClient(), array(
			'1.0/ec2_security_group/js/response',
			'1.0/ec2_security_groups_update/add_cidr_one_rule/response'
		));
		$secgrp = new SecurityGroup();
		$secgrp->find_by_id(12345);
    $secgrp->createCidrRule('tcp', '0.0.0.0/0', 22);
    $lastCommand = $secgrp->getLastCommand();
    $request = (string)$lastCommand->getRequest();

    $this->assertContains('ec2_security_group%5Bprotocol%5D=tcp', $request);
    $this->assertContains('ec2_security_group%5Bfrom_port%5D=22', $request);
    $this->assertContains('ec2_security_group%5Bto_port%5D=22', $request);
    $this->assertContains('ec2_security_group%5Bcidr_ips%5D=0.0.0.0%2F0', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanAddAGroupSecurityGroupPermission() {
		$this->setMockResponse(ClientFactory::getClient(), array(
			'1.0/ec2_security_group/js/response',
			'1.0/ec2_security_groups_update/add_cidr_one_rule/response'
		));

		$secgrp = new SecurityGroup();
		$secgrp->find_by_id(12345);
    $secgrp->createGroupRule('foobarbaz', '0000000000', 'tcp', 22, 22);
    $lastCommand = $secgrp->getLastCommand();
    $request = (string)$lastCommand->getRequest();

    $this->assertContains('ec2_security_group%5Bowner%5D=0000000000', $request);
    $this->assertContains('ec2_security_group%5Bgroup%5D=foobarbaz', $request);
    $this->assertContains('ec2_security_group%5Bprotocol%5D=tcp', $request);
    $this->assertContains('ec2_security_group%5Bfrom_port%5D=22', $request);
    $this->assertContains('ec2_security_group%5Bto_port%5D=22', $request);
	}
	
}