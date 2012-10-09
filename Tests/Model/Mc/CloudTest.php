<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\Cloud;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class CloudTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloudModelExtendsModelBase() {
    $cloud = new Cloud();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $cloud);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage cloud does not implement a create method
   */
  public function testCloudDoesNotImplementCreate() {
    $cloud = new Cloud();
    $cloud->create();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage cloud does not implement an update method
   */
  public function testCloudDoesNotImplementUpdate() {
    $cloud = new Cloud();
    $cloud->update();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage cloud does not implement a destroy method
   */
  public function testCloudDoesNotImplementDestroy() {
    $cloud = new Cloud();
    $cloud->destroy();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage cloud does not implement a duplicate method
   */
  public function testCloudDoesNotImplementDuplidate() {
    $cloud = new Cloud();
    $cloud->duplicate();
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanListAllClouds() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/clouds/json/response');
		$cloud = new Cloud();
		$clouds = $cloud->index();		
		$this->assertEquals(12, count($clouds));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetOneCloud() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/cloud/json/response');
		$cloud = new Cloud();
		$cloud->find_by_id(12345);
		$this->assertEquals(12345, $cloud->id);
		$this->assertEquals(10, count($cloud->links));		
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetAllCloudsAsHash() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/clouds/json/with_different_ids/response');
		$cloud = new Cloud();
		$hash = $cloud->indexAsHash();		
		$this->assertEquals(9, count($hash));
		$this->assertEquals(array(11111, 22222, 33333, 44444, 55555, 66666, 77777, 88888, 99999), array_keys($hash));
		foreach($hash as $cloud_id => $cloud) {
			$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Cloud', $cloud);
		}
	}
	
}