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
		foreach(array('links', 'server_template[description]', 'actions', 'server_template[name]', 'revision') as $prop) {
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
		foreach(array('links', 'inputs', 'server_template[description]', 'actions', 'server_template[name]', 'revision') as $prop) {
			$this->assertContains($prop, $keys);
		}
		$this->assertGreaterThan(0, count($st->inputs));		
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseXmlResponse() {
	  $this->markTestSkipped('Can not parse an XML response. In normal use it will never be required to');	  
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server_template/xml/response');
		$st = new ServerTemplate();
		$st->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $st);
		$keys = array_keys($st->getParameters());		
		foreach(array('links', 'server_template[description]', 'actions', 'server_template[name]', 'revision') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseXmlResponseWithInputs() {
	  $this->markTestSkipped('Can not parse an XML response. In normal use it will never be required to');
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server_template/xml/inputs_view/response');
		$st = new ServerTemplate();
		$st->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $st);
		$keys = array_keys($st->getParameters());		
		foreach(array('links', 'inputs', 'server_template[description]', 'actions', 'server_template[name]', 'revision') as $prop) {
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

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetMultiCloudImagesRelationship() {
		$this->setMockResponse(
			ClientFactory::getClient('1.5'),
			array(
				'1.5/server_template/json/response',
				'1.5/multi_cloud_images/json/response'
			)
		);
		$st = new ServerTemplate();
		$st->find_by_id('12345');
		$mcis = $st->multi_cloud_images();
		$this->assertNotNull($mcis);
		$this->assertInternalType('array', $mcis);
		$this->assertGreaterThan(0, count($mcis));
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $mcis[0]);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetDefaultMultiCloudImageRelationship() {
		$this->setMockResponse(
			ClientFactory::getClient('1.5'),
			array(
				'1.5/server_template/json/response',
				'1.5/multi_cloud_image/json/response'
			)
		);
		$st = new ServerTemplate();
		$st->find_by_id('12345');
		$mci = $st->default_multi_cloud_image();
		$this->assertNotNull($mci);
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $mci);
	}
}