<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\Server;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerTest extends \Guzzle\Tests\GuzzleTestCase {

	protected function setUp() {
		parent::setUp();

		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testExtendsModelBase() {
    $server = new Server();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $server);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server/json/response');
		$server = new Server();
    $server->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Server', $server);
		$keys = array_keys($server->getParameters());		
		foreach(array('links', 'state', 'server[description]', 'actions', 'updated_at', 'created_at', 'server[name]', 'href', 'id') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testExtendsAbstractServer() {
    $server = new Server();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\AbstractServer', $server);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetAlertSpecRelationship() {
  	$this->markTestSkipped('Alert Spec command(s) not yet implemented');
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server/json/response',
  			'1.5/alert_specs/json/response'
			)
  	);
  	$server = new Server();
  	$server->find_by_id('12345');
  	$alert_specs = $server->alert_specs();
  	$this->assertGreaterThan(0, count($alert_specs));
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetNextInstanceRelationship() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server/json/response',
  			'1.5/instance/json/response'
			)
  	);
  	$server = new Server();
  	$server->find_by_id('12345');
  	$next_instance = $server->next_instance();
  	$this->assertNotNull($next_instance);
  	$this->assertInstanceOf('stdClass', $next_instance);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetCurrentInstanceRelationship() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server/json/response',
  			'1.5/instance/json/response'
			)
  	);
  	$server = new Server();
  	$server->find_by_id('12345');
  	$current_instance = $server->current_instance();
  	$this->assertNotNull($current_instance);
  	$this->assertInstanceOf('stdClass', $current_instance);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetDeploymentRelationship() {
  	$this->markTestSkipped('Deployment command(s) not yet implemented');
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server/json/response',
  			'1.5/deployment/json/response'
			)
  	);
  	$server = new Server();
  	$server->find_by_id('12345');
  	$deployment = $server->deployment();
  	$this->assertNotNull($deployment);
  	$this->assertInstanceOf('stdClass', $deployment);
  }
}