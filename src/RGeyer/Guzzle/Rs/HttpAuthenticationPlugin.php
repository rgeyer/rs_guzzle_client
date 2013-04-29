<?php
// Copyright 2013 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

// http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace RGeyer\Guzzle\Rs;

use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HttpAuthenticationPlugin implements EventSubscriberInterface {

  /**
   * @var RightScaleClient
   */
  protected $client;

  public function __construct(RightScaleClient $client) {
    $this->client = $client;
  }

  /**
   * Returns an array of event names this subscriber wants to listen to.
   *
   * The array keys are event names and the value can be:
   *
   *  * The method name to call (priority defaults to 0)
   *  * An array composed of the method name to call and the priority
   *  * An array of arrays composed of the method names to call and respective
   *    priorities, or 0 if unset
   *
   * For instance:
   *
   *  * array('eventName' => 'methodName')
   *  * array('eventName' => array('methodName', $priority))
   *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
   *
   * @return array The event names to listen to
   *
   * @api
   */
  public static function getSubscribedEvents()
  {
    return array(
      'request.sent'      => 'onRequestSent',
      'request.exception' => 'onRequestSent'
    );
  }

  /**
   * @param \Guzzle\Common\Event $event The guzzle event that will be checked for a 401 and authenticated and retried as appropriate
   */
  public function onRequestSent(Event $event) {
    $request = $event['request'];
    $response = $event['response'];
    $exception = $event['exception'];

    if($response && $response->getStatusCode() == 403) {
      $params = $request->getParams();
      if($params->get('plugins.http_authentication.retry_count') < 1) {
        $this->authenticateRequest();
        if($this->client->getDefaultHeaders()->hasKey('Authorization')) {
          $request->setHeader('Authorization', $this->client->getDefaultHeaders()->get('Authorization'));
        }
        $this->retryRequest($request);
      }
    }
  }

  protected function authenticateRequest() {
    $authDeetz = $this->client->getAuthenticationDetails();
    if(in_array('oauth_refresh_token', array_keys($authDeetz))) {
      $request = $this->client->getCommand('oauth',
        array('refresh_token' => $authDeetz['oauth_refresh_token'])
      );
      $request->execute();
      $result = $request->getResult();
      $this->client->getDefaultHeaders()->add('Authorization', 'Bearer '.$result->access_token);
    } else {
      $request = null;
      if($this->client->getVersion() == "1.0") {
        $request = $this->client->get('/api/acct/'.$authDeetz['acct_num'].'/login');
        $request->setAuth($authDeetz['email'], $authDeetz['password']);
      } else {
        $request = $this->client->post(
          '/api/session',
          null,
          array(
            'email' => $authDeetz['email'],
            'password' => $authDeetz['password'],
            'account_href' => '/api/accounts/'.$authDeetz['acct_num']
          )
        );
      }
      $request->setHeader('Accept', '*/*');
      $request->setHeader('X-API-VERSION', $this->client->getVersion());
      $request->send();
    }
  }

  protected function retryRequest(RequestInterface $request) {
    $params = $request->getParams();
    $retries = intval($params->get('plugins.http_authentication.retry_count')) + 1;
    $params->set('plugins.http_authentication.retry_count', $retries);
    $request->send();
  }
}