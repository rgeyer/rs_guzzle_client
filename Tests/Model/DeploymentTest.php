<?php

namespace Guzzle\Rs\Test\Model;

use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Common\ClientFactory;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class DeploymentTest extends ClientCommandsBase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/login');
		ClientFactory::getClient()->get('login')->send();		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanCreateDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/deployments_create/response');
		$deployment = new Deployment();
		$deployment->create(array('deployment[nickname]' => 'foo', 'deployment[description]' => 'bar'));
		$this->assertEquals(12345, $deployment->id);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanFindDeploymentByIdJson() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/deployment/js/response');
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		
		$this->assertEquals(12345, $deployment->id);
		$this->assertEquals("This'll stick around for a bit", $deployment->description);
		$this->assertStringStartsWith('Guzzle_Test_', $deployment->nickname);
		$this->assertEquals('', $deployment->default_vpc_subnet_href);
		$this->assertEquals('', $deployment->default_ec2_availability_zone);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanFindDeploymentByIdXml() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/deployment/xml/response');
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		
		$this->assertEquals(12345, $deployment->id);
		$this->assertEquals("This'll stick around for a bit", $deployment->description);
		$this->assertStringStartsWith('Guzzle_Test_', $deployment->nickname);
		$this->assertEquals('', $deployment->default_vpc_subnet_href);
		$this->assertEquals('', $deployment->default_ec2_availability_zone);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanListAllDeploymentsJson() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/deployments/js/response');
		$deployment = new Deployment();
		$deployments = $deployment->index();
		
		$this->assertGreaterThan(0, count($deployments));
		$this->assertInstanceOf('Guzzle\Rs\Model\Deployment', $deployments[0]);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanListAllDeploymentsXml() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/deployments/xml/response');
		$deployment = new Deployment();
		$deployments = $deployment->index();
		
		$this->assertGreaterThan(0, count($deployments));
		$this->assertInstanceOf('Guzzle\Rs\Model\Deployment', $deployments[0]);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanUpdateDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/deployment/js/response', '1.0/deployments_update/description/response'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$deployment->description = "New Description";
		$deployment->update();
		$this->assertEquals(204, $deployment->getLastCommand()->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanDestroyDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/deployment/js/response', '1.0/deployments_destroy/response'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->destroy();
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanDuplicateDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/deployment/js/response', '1.0/deployments_duplicate/response'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->duplicate();
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanStartAll() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/deployment/js/response', '1.0/deployments_start_all/response'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->start_all();
		$this->assertEquals(201, $result->getStatusCode());		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanStopAll() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/deployment/js/response', '1.0/deployments_stop_all/response'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->stop_all();
		$this->assertEquals(201, $result->getStatusCode());		
	}

}

?>