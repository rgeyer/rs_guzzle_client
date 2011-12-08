<?php

namespace Guzzle\Rs\Test\Model;

use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Common\ClientFactory;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class DeploymentTest extends ClientCommandsBase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient(), 'login');
		ClientFactory::getClient()->get('login')->send();		
	}
	
	public function testCanCreateDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), 'Deployment/create');
		$deployment = new Deployment();
		$deployment->create(array('deployment[nickname]' => 'foo', 'deployment[description]' => 'bar'));
		$this->assertEquals(12345, $deployment->id);
	}
	
	public function testCanFindDeploymentById() {
		$this->setMockResponse(ClientFactory::getClient(), 'Deployment/show');
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		
		$this->assertEquals(12345, $deployment->id);
		$this->assertEquals('Description', $deployment->description);
		$this->assertEquals('Nickname', $deployment->nickname);
		$this->assertEquals('', $deployment->default_vpc_subnet_href);
		$this->assertEquals('', $deployment->default_ec2_availability_zone);
	}
	
	public function testCanListAllDeployments() {
		$this->setMockResponse(ClientFactory::getClient(), 'Deployment/index');
		$deployment = new Deployment();
		$deployments = $deployment->index();
		
		$this->assertGreaterThan(0, count($deployments));
		$this->assertInstanceOf('Guzzle\Rs\Model\Deployment', $deployments[0]);
	}
	
	public function testCanUpdateDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), array('Deployment/show', 'Deployment/update'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$deployment->nickname = "New Nickname";
		$deployment->update();
	}
	
	public function testCanDestroyDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), array('Deployment/show', 'Deployment/update'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->destroy();
		$this->assertEquals(204, $result->getStatusCode());
	}
	
	public function testCanDuplicateDeployment() {
		$this->setMockResponse(ClientFactory::getClient(), array('Deployment/show', 'Deployment/duplicate'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->duplicate();
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	public function testCanStartAll() {
		$this->setMockResponse(ClientFactory::getClient(), array('Deployment/show', 'Deployment/start_all'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->start_all();
		$this->assertEquals(201, $result->getStatusCode());		
	}
	
	public function testCanStopAll() {
		$this->setMockResponse(ClientFactory::getClient(), array('Deployment/show', 'Deployment/stop_all'));
		$deployment = new Deployment();
		$deployment->find_by_id(12345);
		$result = $deployment->stop_all();
		$this->assertEquals(201, $result->getStatusCode());		
	}

}

?>