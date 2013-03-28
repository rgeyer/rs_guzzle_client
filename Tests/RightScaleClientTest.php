<?php
namespace RGeyer\Guzzle\Rs\Tests;

use RGeyer\Guzzle\Rs\RightScaleClient;

class RightScaleClientTest extends \PHPUnit_Framework_TestCase {

  public function testDecorateRequestPrefixesFor1_0() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.0',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $request = null;
    $client->decorateRequest('GET', 'bar/baz', array(), $request);
    $this->assertContains('/api/acct/{acct_num}/bar/baz', strval($request));
  }

  public function testDecorateRequestPrefixesFor1_5() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $request = null;
    $client->decorateRequest('GET', 'bar/baz', array(), $request);
    $this->assertContains('/api/bar/baz', strval($request));
  }

  public function testDecorateRequestSetsHeaderFor1_0() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.0',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $request = null;
    $client->decorateRequest('GET', 'bar/baz', array(), $request);
    $this->assertEquals('1.0', $request->getHeader('X-API-VERSION'));
  }

  public function testDecorateRequestSetsHeaderFor1_5() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $request = null;
    $client->decorateRequest('GET', 'bar/baz', array(), $request);
    $this->assertEquals('1.5', $request->getHeader('X-API-VERSION'));
  }

  public function testDecorateRequestGetEncodesUriValues() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $request = null;
    $client->decorateRequest(
      'GET',
      'bar/baz',
      array(
        'foo' => 'bar', # Normal key/value pair
        'filter' => array('name==AWS*'), # Array value with integer keys (plain array)
        'server' => array('instance' => 'name') # Hash style array
      ),
      $request
    );
    $this->assertContains('/api/bar/baz?foo=bar&filter[]=name%3D%3DAWS%2A&server[instance]=name', strval($request));
  }

  public function testDecorateRequestAllowsMultipleValuesForTheSameKey() {

    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $request = null;
    $client->decorateRequest(
      'GET',
      'bar/baz',
      array(
        'resource_hrefs' => array('/api/href/1', '/api/href/2'),
        'tags' => array('foo', 'bar', 'baz')
      ),
      $request
    );
    $this->assertContains('resource_hrefs[]=%2Fapi%2Fhref%2F1&resource_hrefs[]=%2Fapi%2Fhref%2F2&tags[]=foo&tags[]=bar&tags[]=baz', strval($request));
  }

}