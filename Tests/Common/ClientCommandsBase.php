<?php
// Copyright 2011 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

// http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Guzzle\Rs\Tests\Common;


class ClientCommandsBase extends \Guzzle\Tests\GuzzleTestCase {
	
	protected $_client;

	protected $_testTs;	
	
	protected function setUp() {
		parent::setUp();
		
		$this->_testTs = time();
		
		$this->_client = $this->getServiceBuilder()->get('test.guzzle-rs-1_0');
		$login_cmd = $this->_client->getCommand('login', array('email' => $_SERVER['EMAIL'], 'password' => $_SERVER['PASSWORD']));
		$login_resp = $login_cmd->execute();
	}
}

?>