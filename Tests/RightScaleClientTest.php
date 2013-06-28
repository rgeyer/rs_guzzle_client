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
    $this->assertContains('/api/acct/1234/bar/baz', strval($request));
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

  public function testDecorateRequestAllowsMultipleValuesForTheSameKeyOnGET() {
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

  public function testDecorateRequestAllowsMultipleValuesForTheSameKeyOnPOST() {
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
      'POST',
      'bar/baz',
      array(
        'resource_hrefs' => array('/api/href/1', '/api/href/2'),
        'tags' => array('foo', 'bar', 'baz')
      ),
      $request
    );
    $this->assertContains('resource_hrefs[]=%2Fapi%2Fhref%2F1&resource_hrefs[]=%2Fapi%2Fhref%2F2&tags[]=foo&tags[]=bar&tags[]=baz', strval($request));
  }

  public function testDecorateRequestAllowsMultipleValuesForTheSameKeyOnPUT() {
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
      'PUT',
      'bar/baz',
      array(
        'resource_hrefs' => array('/api/href/1', '/api/href/2'),
        'tags' => array('foo', 'bar', 'baz')
      ),
      $request
    );
    $this->assertContains('resource_hrefs[]=%2Fapi%2Fhref%2F1&resource_hrefs[]=%2Fapi%2Fhref%2F2&tags[]=foo&tags[]=bar&tags[]=baz', strval($request));
  }

  public function testDecorateRequestAllowsMultipleValuesForTheSameKeyWhenValuesAreHashes() {
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
      'POST',
      'bar/baz',
      array(
        'server_array[datacenter_policy]' => array(
          array(
            'datacenter_href' => '/api/dc/href1',
            'max' => 0,
            'weight' => 40
          ),
          array(
            'datacenter_href' => '/api/dc/href2',
            'max' => 0,
            'weight' => 40
          )
        ),
      ),
      $request
    );
    $this->assertContains('server_array[datacenter_policy][][datacenter_href]=%2Fapi%2Fdc%2Fhref1', strval($request));
    $this->assertContains('server_array[datacenter_policy][][datacenter_href]=%2Fapi%2Fdc%2Fhref2', strval($request));
  }

  public function testDecorateRequestSetsBodyTypeOnPOST() {
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
      'POST',
      'bar/baz',
      array(),
      $request
    );
    $this->assertContains('Content-Type: application/x-www-form-urlencoded', strval($request));
  }

  public function testDecorateRequestSetsBodyTypeOnPUT() {
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
      'PUT',
      'bar/baz',
      array(),
      $request
    );
    $this->assertContains('Content-Type: application/x-www-form-urlencoded', strval($request));
  }

  public function testDecorateRequestIgnoresNullValueParams() {
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
      'POST',
      'bar/baz',
      array('a' => null),
      $request
    );
    $this->assertNotContains('a=', strval($request));
  }

  public function testDecorateRequestIgnoresEmptyStringValueParams() {
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
      'POST',
      'bar/baz',
      array('a' => ""),
      $request
    );
    $this->assertNotContains('a=', strval($request));
  }

  public function testDecorateRequestDoesNotIgnoreZeroIntegerValueParams() {
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
      'POST',
      'bar/baz',
      array('a' => 0),
      $request
    );
    $this->assertContains('a=0', strval($request));
  }

  public function testDecorateRequestDoesNotIgnoreFalseBooleanValueParams() {
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
      'POST',
      'bar/baz',
      array('a' => false),
      $request
    );
    $this->assertContains('a=false', strval($request));
  }

  public function testGetAuthenticationDetailsReturnsEmailPasswordWhenOnlyEmailPasswordSupplied() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'acct_num' => '1234'
      )
    );
    $authDeetz = $client->getAuthenticationDetails();
    $this->assertEquals(array('acct_num', 'email', 'password'), array_keys($authDeetz));
  }

  public function testGetAuthenticationDetailsReturnsOauthTokenWhenOnlyOauthTokenSupplied() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'oauth_refresh_token' => 'abc123',
        'acct_num' => '1234'
      )
    );
    $authDeetz = $client->getAuthenticationDetails();
    $this->assertEquals(array('acct_num', 'oauth_refresh_token'), array_keys($authDeetz));
  }

  public function testGetAuthenticationDetailsReturnsOauthTokenWhenBothAreSupplied() {
    $client = RightScaleClient::factory(
      array(
        'version' => '1.5',
        'email' => 'foo@bar.baz',
        'password' => 'password',
        'oauth_refresh_token' => 'abc123',
        'acct_num' => '1234'
      )
    );
    $authDeetz = $client->getAuthenticationDetails();
    $this->assertEquals(array('acct_num', 'oauth_refresh_token'), array_keys($authDeetz));
  }

}