<?php
namespace RGeyer\Guzzle\Rs\Tests;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\ShardAwarenessPlugin;

class ShardAwarenessPluginTest extends \PHPUnit_Framework_TestCase {

  public function testDoesNothingOnSuccessfulRequest() {
    $client = ClientFactory::getClient();
    $plugin = new ShardAwarenessPlugin($client);
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(200));
    $event = $this->getMock('Guzzle\Common\Event');
    $map = array(
      'request' => null,
      'response' => $response,
      'exception' => null
    );
    $event->expects($this->exactly(3))
      ->method('offsetGet')
      ->will($this->returnCallback(function ($key) use ($map) {
                 return $map[$key];
               }));

    $plugin->onRequestSent($event);
  }

  public function testResetsClientBaseUrlOnRedirect() {
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.0'));
    $client->expects($this->once())
      ->method('setBaseUrl')
      ->with('https://us-3.rightscale.com/');
    $plugin = new ShardAwarenessPlugin($client);
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->once())
      ->method('send');
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(302));
    $response->expects($this->once())
      ->method('getHeader')
      ->will($this->returnValue('https://us-3.rightscale.com/'));
    $event = $this->getMock('Guzzle\Common\Event');
    $map = array(
      'request' => $request,
      'response' => $response,
      'exception' => null
    );
    $event->expects($this->exactly(3))
      ->method('offsetGet')
      ->will($this->returnCallback(function ($key) use ($map) {
                 return $map[$key];
               }));
    $plugin->onRequestSent($event);
  }

}