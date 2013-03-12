<?php
namespace RGeyer\Guzzle\Rs\Tests\Command;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

use RGeyer\Guzzle\Rs\Command\DynamicCommandAdapter;

class DynamicCommandAdapterTest extends \Guzzle\Tests\GuzzleTestCase {

	public static function setUpBeforeClass() {
    $classToApproximateThis = new DynamicCommandAdapterTest();
		$classToApproximateThis->setMockResponse(ClientFactory::getClient("1.5"), '1.5/login');
		ClientFactory::getClient("1.5")->post('/api/session')->send();
	}

  public function testIsInstantiatedWithCallingClient() {
    $client = ClientFactory::getClient("1.5");
    $dynamicCommandAdapter = $client->clouds();
    $this->assertEquals($client, $dynamicCommandAdapter->getClient());
  }

  public function testIsReturnedFromClient() {
    $client = ClientFactory::getClient("1.5");
    $dynamicCommandAdapter = $client->clouds();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DynamicCommandAdapter', $dynamicCommandAdapter);
  }

  public function testInitialPathIsSetWithoutId() {
    $client = ClientFactory::getClient("1.5");
    $dynamicCommandAdapter = $client->clouds();
    $this->assertEquals('clouds', $dynamicCommandAdapter->getUri());
  }

  public function testInitialPathIsSetWithId() {
    $client = ClientFactory::getClient("1.5");
    $dynamicCommandAdapter = $client->clouds("123");
    $this->assertEquals('clouds/123', $dynamicCommandAdapter->getUri());
  }

  public function testCanIndexWhenNoIdProvided() {
    $client = ClientFactory::getClient("1.5");
    $this->setMockResponse($client, '1.5/clouds/json/response');
    $client->clouds()->index();
    $requests = $this->getMockedRequests();
    $request = $requests[0];
    $this->assertContains('GET', strval($request));
    $this->assertContains('/clouds', strval($request));
  }

  /**
   * @group unit
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage clouds/123
   */
  public function testCanNotIndexWhenIdProvided() {
    $client = ClientFactory::getClient("1.5");
    $client->clouds("123")->index();
  }

  public function testIndexReturnsObject() {
    $client = ClientFactory::getClient("1.5");
    $this->setMockResponse($client, '1.5/clouds/json/response');
    $response = $client->clouds()->index();
    $this->assertTrue(is_array($response));
    $this->assertGreaterThan(0, count($response));
    $this->assertInstanceOf('stdClass', $response[0]);
  }

  public function testIndexPassesParametersThrough() {
    $client = ClientFactory::getClient("1.5");
    $this->setMockResponse($client, '1.5/clouds/json/response');
    $client->clouds()->index(array('filter' => array('name==AWS AP')));
    $requests = $this->getMockedRequests();
    $request = $requests[0];
    $this->assertContains('/api/clouds?filter[]=name%3D%3DAWS%20AP', strval($request));
  }

  /**
   * @group unit
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage clouds
   */
  public function testCanNotShowWhenNoIdProvided() {
    $client = ClientFactory::getClient("1.5");
    $client->clouds()->show();
  }

  public function testCanShowWhenIdProvided() {
    $client = ClientFactory::getClient("1.5");
    $this->setMockResponse($client, '1.5/cloud/json/response');
    $client->clouds("123")->show();
    $requests = $this->getMockedRequests();
    $request = $requests[0];
    $this->assertContains('GET', strval($request));
    $this->assertContains('/clouds/123', strval($request));
  }

  public function testShowReturnsObject() {

  }

  public function testShowPassesParametersThrough() {

  }
}
