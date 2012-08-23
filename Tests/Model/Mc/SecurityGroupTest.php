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
	
}