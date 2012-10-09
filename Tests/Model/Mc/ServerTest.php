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
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server/json/response');
		$server = new Server();
    $server->find_by_id('12345');
    $this->assertEquals($server->id, '12345');
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testExtendsAbstractServer() {
    $server = new Server();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\AbstractServer', $server);
  }
}