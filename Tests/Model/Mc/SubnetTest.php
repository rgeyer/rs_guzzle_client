<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\Subnet;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class SubnetTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testSubnetModelExtendsModelBase() {
    $cloud = new Subnet();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $cloud);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/subnet/json/response');
		$subnet = new Subnet();
    $subnet->find_by_id('abc123', array('cloud_id' => '12345'));
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Subnet', $subnet);
		$keys = array_keys($subnet->getParameters());
    $expected_props = array(
      'visibility',
      'state',
      'cidr_block',
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
   * @expectedException \BadMethodCallException
   * @expectedExceptionMessage subnet does not implement a create method
   */
  public function testSubnetDoesNotImplementCreate() {
    $subnet = new Subnet();
    $subnet->create();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \BadMethodCallException
   * @expectedExceptionMessage subnet does not implement a destroy method
   */
  public function testInstanceTypeDoesNotImplementDestroy() {
    $subnet = new Subnet();
    $subnet->destroy();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \BadMethodCallException
   * @expectedExceptionMessage subnet does not implement a duplicate method
   */
  public function testInstanceTypeDoesNotImplementDuplicate() {
    $subnet = new Subnet();
    $subnet->duplicate();
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanListAllInstanceTypes() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/subnets/json/response');
		$subnet = new Subnet();
    $subnet->cloud_id = 12345;
		$subnets = $subnet->index();
		$this->assertEquals(6, count($subnets));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetOneInstanceType() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/subnet/json/response');
		$subnet = new Subnet();
		$subnet->find_by_id('abc123', array('cloud_id' => '12345'));
		$this->assertEquals('EDRBD9G19S63T', $subnet->id);
		$this->assertEquals(3, count($subnet->links));
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetDatacenterRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/subnet/json/response',
        '1.5/datacenter/json/response'
      )
    );
		$subnet = new Subnet();
    $subnet->find_by_id('abc123', array('cloud_id' => '12345'));
    $dc = $subnet->datacenter();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Datacenter', $dc);
  }
	
}