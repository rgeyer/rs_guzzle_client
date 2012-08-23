<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\SecurityGroup;

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
	public function testCanAddACidrSecurityGroupPermission() {
		$this->setMockResponse(ClientFactory::getClient(), array(
			'1.0/ec2_security_group/js/response',
			'1.0/ec2_security_groups_update/add_cidr_one_rule/response'
		));
		$secgrp = new SecurityGroup();
		$secgrp->find_by_id(12345);
		$secgrp->update(array(
      'ec2_security_group[protocol]' => 'tcp',
      'ec2_security_group[from_port]' => 22,
      'ec2_security_group[to_port]' => 22,
      'ec2_security_group[cidr_ips]' => '0.0.0.0/0')
    );
		$this->assertEquals(204, $secgrp->getLastCommand()->getResponse()->getStatusCode());
	}
	
}