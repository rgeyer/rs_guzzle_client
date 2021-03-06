<?php
// Copyright 2011-2012 Ryan J. Geyer
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

use RGeyer\Guzzle\Rs\Common\ClientFactory;


class ClientCommandsBase extends \Guzzle\Tests\GuzzleTestCase {
	
	/**
	 * 
	 * @var RightScaleClient
	 */
	protected $_client;
	
	/**
	 * 
	 * @var RightScaleClient
	 */
	protected $_client_v1_5;

	protected $_testTs;

  public static function setUpBeforeClass() {
    $classToApproximateThis = new ClientCommandsBase();

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
	
	protected function setUp() {
		parent::setUp();
		$this->_testTs = time();
		
		$this->_client = $this->getServiceBuilder()->get('test.guzzle-rs-1_0');
		$this->_client_v1_5 = $this->getServiceBuilder()->get('test.guzzle-rs-1_5');
	}
	
	/**
	 * Does the heavy lifting of getting and executing a command for API v1.0
	 *
	 * @param string $commandName The name of the dynamic command specified in the xml file
	 * @param array $params The array of parameters for the command
	 * @param CommandInterface $command A reference to an object which will get set to the command interface object
	 * @param string $variant A description which will become part of the path for the mock request/response files if $_SERVER['HTTP_TRACE'] is set
	 *
	 * @return mixed Either a CommandInterface or the specific model as defined in the xml file
	 */
	protected function executeCommand($commandName, array $params = array(), &$command = null, $variant = null) {
		return $this->_executeCommand($this->_client, $commandName, $params, $command, $variant);
	}
	
	/**
	 * Does the heavy lifting of getting and executing a command for API v1.5
	 *
	 * @param string $commandName The name of the dynamic command specified in the xml file
	 * @param array $params The array of parameters for the command
	 * @param CommandInterface $command A reference to an object which will get set to the command interface object
	 * @param string $variant A description which will become part of the path for the mock request/response files if $_SERVER['HTTP_TRACE'] is set
	 *
	 * @return mixed Either a CommandInterface or the specific model as defined in the xml file
	 */
	protected function executeCommand1_5($commandName, array $params = array(), &$command = null, $variant = null) {
		return $this->_executeCommand($this->_client_v1_5, $commandName, $params, $command, $variant);
	}
	
	/**
	 * Does the heavy lifting of getting and executing a command 
	 * 
	 * @param RightScaleClient $client An instantiated RightScaleClient object for the desired version of the API
	 * @param string $commandName The name of the dynamic command specified in the xml file
	 * @param array $params The array of parameters for the command
	 * @param CommandInterface $command A reference to an object which will get set to the command interface object
	 * @param string $variant A description which will become part of the path for the mock request/response files if $_SERVER['HTTP_TRACE'] is set
	 * 
	 * @return mixed Either a CommandInterface or the specific model as defined in the xml file
	 */
	protected function _executeCommand($client, $commandName, array $params = array(), &$command = null, $variant = null) {
    // Clear any mocked login cookies
    $client->getCookieJar()->remove();
		$command = $client->getCommand($commandName, $params);
		$command->execute();
		$result = $command->getResult();

		if($_ENV['HTTP_TRACE'] == 'true') {
			$dir = __DIR__ . '/../' . 'mock/' . $client->getConfig('version') . '/' . $commandName;			
			$command_params = $command->getAll();			
			if(array_key_exists('output_format', $command_params)) {
				$dir .= '/' . str_replace('.', '', $command_params['output_format']);
			}
			if($variant) {
				$dir .= '/' . $variant;
			}
			if(!is_dir($dir)) {
				mkdir($dir, 0775, true);
			}
			$request_str = $command->getRequest();
			$response_str = $command->getResponse();
			if($_ENV['OBFUSCATE_IDS'] == 'true') {
				// TODO handle GET params?
				// TODO Kill them SSH keys				
				$rs_acct_regex = ',(?<!PHP|HTTP|Guzzle|nginx|[0-9]{4}|[0-9]{2}|\.[0-9]{1}|\.[0-9]{2}|\.[0-9]{3})/[0-9]+,';
				$request_str = preg_replace($rs_acct_regex, '/12345', $request_str);
				$request_str = preg_replace(',[0-9]{12},', '000000000000', $request_str);
				$response_str = preg_replace($rs_acct_regex, '/12345', $response_str);
				$response_str = preg_replace('/-----BEGIN RSA PRIVATE KEY-----.*-----END RSA PRIVATE KEY-----/', 'obfuscated', $response_str);
				$response_str = preg_replace(',[0-9]{12},', '000000000000', $response_str);
			}
			file_put_contents($dir . '/request', $request_str);
			file_put_contents($dir . '/response', $response_str);
		}
		
		return $result;
	}
}

?>