<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\InstanceType;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class InstanceTypeTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testInstanceTypeModelExtendsModelBase() {
    $cloud = new InstanceType();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $cloud);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/instance_type/json/response');
		$instance_type = new InstanceType();
		$instance_type->find_by_id('abc123', array('cloud_id' => '12345'));
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\InstanceType', $instance_type);
		$keys = array_keys($instance_type->getParameters());
    $expected_props = array(
      'actions',
      'cpu_count',
      'local_disks',
      'cpu_architecture',
      'resource_uid',
      'cpu_speed',
      'memory',
      'local_disk_size',
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
   * @expectedExceptionMessage instance_type does not implement a create method
   */
  public function testInstanceTypeDoesNotImplementCreate() {
    $instance_type = new InstanceType();
    $instance_type->create();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage instance_type does not implement an update method
   */
  public function testInstanceTypeDoesNotImplementUpdate() {
    $instance_type = new InstanceType();
    $instance_type->update();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage instance_type does not implement a destroy method
   */
  public function testInstanceTypeDoesNotImplementDestroy() {
    $instance_type = new InstanceType();
    $instance_type->destroy();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage instance_type does not implement a duplicate method
   */
  public function testInstanceTypeDoesNotImplementDuplidate() {
    $instance_type = new InstanceType();
    $instance_type->duplicate();
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanListAllInstanceTypes() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/instance_types/json/response');
		$instance_type = new InstanceType();
    $instance_type->cloud_id = 12345;
		$instance_types = $instance_type->index();
		$this->assertEquals(16, count($instance_types));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetOneInstanceType() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/instance_type/json/response');
		$instance_type = new InstanceType();
		$instance_type->find_by_id('abc123', array('cloud_id' => '12345'));
		$this->assertEquals('12345U7NRRI3I0UM', $instance_type->id);
		$this->assertEquals(2, count($instance_type->links));
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetCloudRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/instance_type/json/response',
        '1.5/cloud/json/response'
      )
    );
		$instance_type = new InstanceType();
    $instance_type->find_by_id('abc123', array('cloud_id' => '12345'));
    $cloud = $instance_type->cloud();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Cloud', $cloud);
  }
	
}