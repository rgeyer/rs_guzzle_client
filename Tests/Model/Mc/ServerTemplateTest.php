<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate;

class ServerTemplateTest extends ClientCommandsBase {
	
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
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server_template/json/response');
		$st = new ServerTemplate();
		$st->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $st);
		$keys = array_keys($st->getParameters());		
		foreach(array('links', 'description', 'actions', 'name', 'revision') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponseWithInputs() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server_template/json/inputs_view/response');
		$st = new ServerTemplate();
		$st->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $st);
		$keys = array_keys($st->getParameters());		
		foreach(array('links', 'inputs', 'description', 'actions', 'name', 'revision') as $prop) {
			$this->assertContains($prop, $keys);
		}
		$this->assertGreaterThan(0, count($st->inputs));		
	}

	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDuplicateMethod() {
		$st = new ServerTemplate();
		$st->duplicate();
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetPublicationRelationship() {
		$this->setMockResponse(
			ClientFactory::getClient('1.5'),
			array(
				'1.5/server_template/json/response',
				'1.5/publication/json/response'
			)
		);
		$st = new ServerTemplate();
		$st->find_by_id('12345');
		$pub = $st->publication();
		$this->assertNotNull($pub);
		$this->assertInstanceOf('stdClass', $pub);
	}
}