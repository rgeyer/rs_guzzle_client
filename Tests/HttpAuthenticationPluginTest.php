<?php
namespace RGeyer\Guzzle\Rs\Tests;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\HttpAuthenticationPlugin;

class HttpAuthenticationPluginTest extends \PHPUnit_Framework_TestCase {

  public function testDoesNothingOnSuccessfulRequest() {
    $client = ClientFactory::getClient();
    $plugin = new HttpAuthenticationPlugin($client);
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

public function testDoesNotRetryMoreThanOnce() {
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'email' => 'email', 'password' => 'password')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.0'));
    $plugin = new HttpAuthenticationPlugin($client);
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(3))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $request->expects($this->exactly(2))
      ->method('send');
    $request->expects($this->once())
      ->method('setAuth');
    $client->expects($this->once())
      ->method('get')
      ->will($this->returnValue($request));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->exactly(2))
      ->method('getStatusCode')
      ->will($this->returnValue(403));
    $event = $this->getMock('Guzzle\Common\Event');
    $map = array(
      'request' => $request,
      'response' => $response,
      'exception' => null
    );
    $event->expects($this->exactly(6))
      ->method('offsetGet')
      ->will($this->returnCallback(function ($key) use ($map) {
                 return $map[$key];
               }));

    $plugin->onRequestSent($event);
    $plugin->onRequestSent($event);
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
  }

  public function testAuthenticatesWithUsernamePasswordAndRetries1_0() {
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'email' => 'email', 'password' => 'password')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.0'));
    $plugin = new HttpAuthenticationPlugin($client);
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(2))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $request->expects($this->exactly(2))
      ->method('send');
    $request->expects($this->once())
      ->method('setAuth');
    $client->expects($this->once())
      ->method('get')
      ->will($this->returnValue($request));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(403));
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
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
  }

  public function testAuthenticatesWithOauthTokenAndRetries1_0() {
    $headersCollection = new \Guzzle\Common\Collection();
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'oauth_refresh_token' => 'abc123')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.0'));
    $client->expects($this->any())
      ->method('getDefaultHeaders')
      ->will($this->returnValue($headersCollection));
    $plugin = new HttpAuthenticationPlugin($client);
    $command = $this->getMockBuilder('RGeyer\Guzzle\Rs\Command\DefaultCommand')
      ->getMock();
    $command->expects($this->once())
      ->method('execute');
    $command->expects($this->once())
      ->method('getResult');
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(2))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $client->expects($this->once())
      ->method('getCommand')
      ->will($this->returnValue($command));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(403));
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
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
  }

  public function testSetsHeaderForOauthToken1_0() {
    $headersCollection = new \Guzzle\Common\Collection();
    $command = $this->getMockBuilder('RGeyer\Guzzle\Rs\Command\DefaultCommand')
      ->getMock();
    $command->expects($this->once())
      ->method('execute');
    $command->expects($this->once())
      ->method('getResult');
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getCommand')
      ->will($this->returnValue($command));
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'oauth_refresh_token' => 'abc123')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.0'));
    $client->expects($this->any())
      ->method('getDefaultHeaders')
      ->will($this->returnValue($headersCollection));
    $plugin = new HttpAuthenticationPlugin($client);
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(2))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(403));
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
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
    $this->assertEquals(1, $headersCollection->count());
    $this->assertcontains('Authorization', $headersCollection->getKeys());
  }

  public function testAuthenticatesWithUsernamePasswordAndRetries1_5() {
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'email' => 'email', 'password' => 'password')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.5'));
    $plugin = new HttpAuthenticationPlugin($client);
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(2))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $request->expects($this->exactly(2))
      ->method('send');
    $request->expects($this->never())
      ->method('setAuth');
    $client->expects($this->once())
      ->method('post')
      ->will($this->returnValue($request));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(403));
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
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
  }

  public function testAuthenticatesWithOauthTokenAndRetries1_5() {
    $headersCollection = new \Guzzle\Common\Collection();
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'oauth_refresh_token' => 'abc123')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.5'));
    $client->expects($this->any())
      ->method('getDefaultHeaders')
      ->will($this->returnValue($headersCollection));
    $plugin = new HttpAuthenticationPlugin($client);
    $command = $this->getMockBuilder('RGeyer\Guzzle\Rs\Command\DefaultCommand')
      ->getMock();
    $command->expects($this->once())
      ->method('execute');
    $command->expects($this->once())
      ->method('getResult');
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(2))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $client->expects($this->once())
      ->method('getCommand')
      ->will($this->returnValue($command));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(403));
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
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
  }

  public function testSetsHeaderForOauthToken1_5() {
    $headersCollection = new \Guzzle\Common\Collection();
    $command = $this->getMockBuilder('RGeyer\Guzzle\Rs\Command\DefaultCommand')
      ->getMock();
    $command->expects($this->once())
      ->method('execute');
    $command->expects($this->once())
      ->method('getResult');
    $client = $this->getMockBuilder('RGeyer\Guzzle\Rs\RightScaleClient')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->once())
      ->method('getCommand')
      ->will($this->returnValue($command));
    $client->expects($this->once())
      ->method('getAuthenticationDetails')
      ->will($this->returnValue(array('acct_num' => '123', 'oauth_refresh_token' => 'abc123')));
    $client->expects($this->any())
      ->method('getVersion')
      ->will($this->returnValue('1.5'));
    $client->expects($this->any())
      ->method('getDefaultHeaders')
      ->will($this->returnValue($headersCollection));
    $plugin = new HttpAuthenticationPlugin($client);
    $request_params = new \Guzzle\Common\Collection();
    $request = $this->getMockBuilder('Guzzle\Http\Message\Request')
      ->disableOriginalConstructor()
      ->getMock();
    $request->expects($this->exactly(2))
      ->method('getParams')
      ->will($this->returnValue($request_params));
    $response = $this->getMockBuilder('Guzzle\Http\Message\Response')
      ->disableOriginalConstructor()
      ->getMock();
    $response->expects($this->once())
      ->method('getStatusCode')
      ->will($this->returnValue(403));
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
    $this->assertEquals(1, $request_params->get('plugins.http_authentication.retry_count'));
    $this->assertEquals(1, $headersCollection->count());
    $this->assertcontains('Authorization', $headersCollection->getKeys());
  }

}