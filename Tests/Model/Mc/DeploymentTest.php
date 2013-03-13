<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\Deployment;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class DeploymentTest extends \Guzzle\Tests\GuzzleTestCase {
	
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
    $cloud = new Deployment();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $cloud);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/deployment/json/response');
		$cloud = new Deployment();
		$cloud->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Deployment', $cloud);
		$keys = array_keys($cloud->getParameters());
		foreach(array('links', 'deployment[description]', 'deployment[name]', 'href', 'id', 'deployment[server_tag_scope]') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

  /**
   * @group v1_5
   * @group unit
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage deployment does not implement a duplicate method
   */
  public function testCloudDoesNotImplementDuplicate() {
    $deployment = new Deployment();
    $deployment->duplicate();
  }
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetOneDeployment() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/deployment/json/response');
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$this->assertEquals(12345, $deployment->id);
		$this->assertEquals(4, count($deployment->links));
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetServerRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/deployment/json/response',
        '1.5/servers/json/response'
      )
    );
		$deployment = new Deployment();
    $deployment->find_by_id(12345);
    $servers = $deployment->servers();
    $this->assertGreaterThan(0, count($servers));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Server', $servers[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetServerArrayRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/deployment/json/response',
        '1.5/server_arrays/json/response'
      )
    );
		$deployment = new Deployment();
    $deployment->find_by_id(12345);
    $server_arrays = $deployment->server_arrays();
    $this->assertGreaterThan(0, count($server_arrays));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerArray', $server_arrays[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetInputRelationship() {
    $this->markTestSkipped("No Input Commands yet");
  }
	
}