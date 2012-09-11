<?php
// Copyright 2012 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

// http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace RGeyer\Guzzle\Rs\Tests\Utils;

class RightScaleClientTestBase extends \Guzzle\Tests\GuzzleTestCase {
  public static function setUpBeforeClass() {
    $classToApproximateThis = new RightScaleClientTestBase();

    // Login to API 1.0 to get a mocked session header
    $client = \RGeyer\Guzzle\Rs\Common\ClientFactory::getClient();
    $classToApproximateThis->setMockResponse($client, array('1.0/login'));
    $request = $client->get('/api/acct/{acct_num}/login');
    $request->send();

    // Login to the API 1.5 to get a mocked session header
    $client = \RGeyer\Guzzle\Rs\Common\ClientFactory::getClient('1.5');
    $classToApproximateThis->setMockResponse($client, array('1.5/login'));
    $request = $client->post('/api/session');
    $request->send();
  }
}