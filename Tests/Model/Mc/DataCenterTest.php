<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\DataCenter;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class DataCenterTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testDataCenterModelExtendsModelBase() {
    $cloud = new DataCenter();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $cloud);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/datacenter/json/response');
		$datacenter = new DataCenter();
		$datacenter->find_by_id('abc123', array('cloud_id' => '12345'));
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\DataCenter', $datacenter);
		$keys = array_keys($datacenter->getParameters());
    $expected_props = array(
      'actions',
      'resource_uid',
      'links',
      'description',
      'name',
      'href',
      'id'
    );
		foreach($expected_props as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage datacenter does not implement a create method
   */
  public function testDataCenterDoesNotImplementCreate() {
    $datacenter = new DataCenter();
    $datacenter->create();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage datacenter does not implement an update method
   */
  public function testDataCenterDoesNotImplementUpdate() {
    $datacenter = new DataCenter();
    $datacenter->update();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage datacenter does not implement a destroy method
   */
  public function testDataCenterDoesNotImplementDestroy() {
    $datacenter = new DataCenter();
    $datacenter->destroy();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage datacenter does not implement a duplicate method
   */
  public function testDataCenterDoesNotImplementDuplidate() {
    $datacenter = new DataCenter();
    $datacenter->duplicate();
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanListAllDataCenters() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/datacenters/json/response');
		$datacenter = new DataCenter();
    $datacenter->cloud_id = 12345;
		$datacenters = $datacenter->index();
		$this->assertEquals(5, count($datacenters));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetOneDataCenter() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/datacenter/json/response');
		$datacenter = new DataCenter();
		$datacenter->find_by_id('abc123', array('cloud_id' => '12345'));
		$this->assertEquals('DBHME7BQV63MI', $datacenter->id);
		$this->assertEquals(2, count($datacenter->links));
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetCloudRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/datacenter/json/response',
        '1.5/cloud/json/response'
      )
    );
		$datacenter = new DataCenter();
    $datacenter->find_by_id('abc123', array('cloud_id' => '12345'));
    $cloud = $datacenter->cloud();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Cloud', $cloud);
  }
	
}