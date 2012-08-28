<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\SecurityGroup1_5;

class SecurityGroupTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/security_groups/json/response');
		// Doing a list rather than a show/find since show does not work
		$secgrp = new SecurityGroup1_5();
		$secgrp->cloud_id = 12345;
		$groups = $secgrp->index();
    // TODO: Actually test something?
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDuplicateMethod() {
		$secgrp = new SecurityGroup1_5();
		$secgrp->duplicate();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportUpdateMethod() {
		$secgrp = new SecurityGroup1_5();
		$secgrp->update();
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanAddACidrSecurityGroupPermissionSpecifyingOnlyOnePort() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), array(
			'1.5/security_group/json/response',
			'1.5/security_group_rules_create/response'
		));
		$secgrp = new SecurityGroup1_5();
    $secgrp->cloud_id = 12345;
		$secgrp->find_by_id('12345');
    $secgrp->createCidrRule('tcp', '0.0.0.0/0', 25);
    $lastCommand = $secgrp->getLastCommand();
    $request = (string)$lastCommand->getRequest();

    $this->assertContains(urlencode('security_group_rule[cidr_ips]') . '=' . urlencode('0.0.0.0/0'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol]') . '=' . urlencode('tcp'), $request);
    $this->assertContains(urlencode('security_group_rule[source_type]') . '=' . urlencode('cidr_ips'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][start_port]') . '=' . urlencode('25'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][end_port]') . '=' . urlencode('25'), $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testSetsIcmpCodeAndTypeWhenProtocolIsIcmp() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), array(
			'1.5/security_group/json/response',
			'1.5/security_group_rules_create/response'
		));
		$secgrp = new SecurityGroup1_5();
    $secgrp->cloud_id = 12345;
		$secgrp->find_by_id('12345');
    $secgrp->createCidrRule('icmp', '0.0.0.0/0', -1);
    $lastCommand = $secgrp->getLastCommand();
    $request = (string)$lastCommand->getRequest();

    $this->assertContains(urlencode('security_group_rule[cidr_ips]') . '=' . urlencode('0.0.0.0/0'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol]') . '=' . urlencode('icmp'), $request);
    $this->assertContains(urlencode('security_group_rule[source_type]') . '=' . urlencode('cidr_ips'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][icmp_code]') . '=' . urlencode('-1'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][icmp_type]') . '=' . urlencode('-1'), $request);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanAddAGroupSecurityGroupPermissionSpecifyingOnlyOnePort() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), array(
			'1.5/security_group/json/response',
			'1.5/security_group_rules_create/response'
		));

		$secgrp = new SecurityGroup1_5();
    $secgrp->cloud_id = 12345;
		$secgrp->find_by_id('12345');
    $secgrp->createGroupRule('foobarbaz', '0000000000', 'tcp', 25);
    $lastCommand = $secgrp->getLastCommand();
    $request = (string)$lastCommand->getRequest();

    $this->assertContains(urlencode('security_group_rule[group_name]') . '=' . urlencode('foobarbaz'), $request);
    $this->assertContains(urlencode('security_group_rule[group_owner]') . '=' . urlencode('0000000000'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol]') . '=' . urlencode('tcp'), $request);
    $this->assertContains(urlencode('security_group_rule[source_type]') . '=' . urlencode('group'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][start_port]') . '=' . urlencode('25'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][end_port]') . '=' . urlencode('25'), $request);
	}

  /**
   * @group v1_5
   * @group unit
   * @expectedException InvalidArgumentException
   * @expectedExceptionMessage ICMP is not supported for group ingress rules.  Please specify a CIDR based ingress rule for ICMP
   */
  public function testAddGroupPermissionThrowsInvalidArgumentWhenProtocolIsIcmp() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), array(
			'1.5/security_group/json/response',
			'1.5/security_group_rules_create/response'
		));

		$secgrp = new SecurityGroup1_5();
    $secgrp->cloud_id = 12345;
		$secgrp->find_by_id('12345');
    $secgrp->createGroupRule('foobarbaz', '0000000000', 'icmp', -1);
    $lastCommand = $secgrp->getLastCommand();
    $lastCommand->getRequest();
  }
}