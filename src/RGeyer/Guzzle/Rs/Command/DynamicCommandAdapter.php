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

namespace RGeyer\Guzzle\Rs\Command;

class DynamicCommandAdapter {

  protected $_bulk;

  /**
   * @var RGeyer\Guzzle\Rs\RightScaleClient
   */
  protected $_client;

  /**
   * @return RGeyer\Guzzle\Rs\RightScaleClient
   */
  public function getClient() {
    return $this->_client;
  }

  protected $_uri;

  public function getUri() {
    return $this->_uri;
  }

  public function __construct($method, $params, $client) {
    $this->_client = $client;
    if(count($params) > 0) {
      $this->_bulk = false;
      $this->_uri = $method . '/' . $params[0];
    } else {
      $this->_bulk = true;
      $this->_uri = $method;
    }
  }

  public function index($params = array()) {
    if(!$this->_bulk) {
      throw new \InvalidArgumentException("Can't get a list of resources for URI ".$this->_uri." because it refers to a single resource id.");
    }

    return $this->_do_get($this->_uri, $params);
  }

  public function show($params = array()) {
    if($this->_bulk) {
      throw new \InvalidArgumentException("Can't get a single resource for URI ".$this->_uri." because it does not refer to a single resource id.");
    }

    return $this->_do_get($this->_uri, $params);
  }

  protected function _do_get($uri, $params) {
    $request = null;
    $this->_client->decorateRequest('GET', $uri, $params, $request);
    $response = $request->send();
    return json_decode($response->getBody());
  }
}