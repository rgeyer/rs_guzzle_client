<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Model\SecurityGroup1_5;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SecurityGroupRulesCommandsTest extends ClientCommandsBase {
	
	/**
	 * 
	 * @var RGeyer\Guzzle\Rs\Model\SecurityGroup1_5
	 */
	protected static $_security_group;
	protected static $testTs;
	
	public static function setUpBeforeClass() {
		/*
		self::$testTs = time();
		self::$_security_group = new SecurityGroup1_5();
		self::$_security_group->name = 'Guzzle_Test_' . self::$testTs;
    self::$_security_group->cloud_id = $_SERVER['SECGRP_CLOUD_ID'];
		self::$_security_group->create();
		*/
	}
	
	public static function tearDownAfterClass() {
		//self::$_security_group->destroy();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanCreateCidrRule() {
    $this->setMockResponse($this->_client_v1_5,
      array(
        '1.5/login',
        '1.5/security_groups_create/response'
      )
    );
		$params = array(
      'cloud_id' => 1234,
      'security_group_id' => 'ABC123',
      'security_group_rule[cidr_ips]' => '0.0.0.0/0',
      'security_group_rule[protocol]' => 'tcp',
      'security_group_rule[protocol_details][start_port]' => '25',
      'security_group_rule[protocol_details][end_port]' => '25',
      'security_group_rule[source_type]' => 'cidr_ips'
    );

    $command = $this->_client_v1_5->getCommand('security_group_rules_create', $params);
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds/1234/security_groups/ABC123/security_group_rules', $request);
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
	public function testCanCreateGroupRule() {
    $this->setMockResponse($this->_client_v1_5,
      array(
        '1.5/login',
        '1.5/security_groups_create/response'
      )
    );
		$params = array(
      'cloud_id' => 1234,
      'security_group_id' => 'ABC123',
      'security_group_rule[group_owner]' => 'ABC123',
      'security_group_rule[group_name]' => 'foobarbaz',
      'security_group_rule[protocol]' => 'tcp',
      'security_group_rule[protocol_details][start_port]' => '25',
      'security_group_rule[protocol_details][end_port]' => '25',
      'security_group_rule[source_type]' => 'cidr_ips'
    );

    $command = $this->_client_v1_5->getCommand('security_group_rules_create', $params);
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds/1234/security_groups/ABC123/security_group_rules', $request);
    $this->assertContains(urlencode('security_group_rule[group_owner]') . '=' . urlencode('ABC123'), $request);
    $this->assertContains(urlencode('security_group_rule[group_name]') . '=' . urlencode('foobarbaz'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol]') . '=' . urlencode('tcp'), $request);
    $this->assertContains(urlencode('security_group_rule[source_type]') . '=' . urlencode('cidr_ips'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][start_port]') . '=' . urlencode('25'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][end_port]') . '=' . urlencode('25'), $request);
	}
	
}