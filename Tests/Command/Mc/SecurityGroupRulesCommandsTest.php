<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\SecurityGroup;
use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class SecurityGroupRulesCommandsTest extends \Guzzle\Tests\GuzzleTestCase {
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanCreateCidrRule() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
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

    $command = $client->getCommand('security_group_rules_create', $params);
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
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
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

    $command = $client->getCommand('security_group_rules_create', $params);
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