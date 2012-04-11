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

namespace Guzzle\Rs\Tests\Utils;

use Guzzle\Rs\Model\ServerTemplate;

use Guzzle\Rs\Common\ClientFactory;


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

	protected $_serverTemplate;
	
	protected $_serverTemplateEbs;
	
	protected function setUp() {
		parent::setUp();
		
		$this->_testTs = time();
		
		$this->_client = $this->getServiceBuilder()->get('test.guzzle-rs-1_0');
		$this->_client_v1_5 = $this->getServiceBuilder()->get('test.guzzle-rs-1_5');

		$st = new ServerTemplate();
		$result_obj = $st->index();
		
		$baseStForLinux = null;
		$baseStForWindows = null;
		foreach($result_obj as $st) {
			if($st->nickname == $_SERVER['ST_NAME']) {
				$this->_serverTemplate = $st;
			}
			if($st->nickname == $_SERVER['ST_EBS_NAME']) {
				$this->_serverTemplateEbs = $st;
			}
		}
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
		$command = $client->getCommand($commandName, $params); 
		$command->execute();
		$result = $command->getResult();
		
		if($_SERVER['HTTP_TRACE'] == 'true') {
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
			if($_SERVER['OBFUSCATE_IDS'] == 'true') {
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
	
	/**
	 * Returns the object id when given the objects basename and it's href.
	 * 
	 * @example $this->getIdFromHref('credentials', 'https://my.rightscale.com/api/acct/12345/credentials/12345');
	 * 
	 * @param string $basename The name of the object as it appears in the URL.  I.E. For Credentials it is "credentials" since the URL looks like https://my.rightscale.com//api/acct/12345/credentials/12345
	 * @param string $href The full API href of the object.  I.E. https://my.rightscale.com/api/acct/12345/credentials/12345
	 * 
	 * @return integer The ID of the object
	 */
	protected function getIdFromHref($basename, $href) {
		$regex = ',https://.+/api/acct/[0-9]+/' . $basename . '/([0-9]+),';
		$matches = array();
		preg_match($regex, $href, $matches);		
		
		return count($matches) > 0 ? $matches[1] : 0;
	}	
	
	/**
	 * Returns the object id when given the objects relative href.
	 *
	 * @example $this->getIdFromRelativeHref('/api/clouds/12345');
	 *
	 * @param string $href The relative API href of the object.  I.E. /api/clouds/12345
	 *
	 * @return integer The ID of the object
	 */
	protected function getIdFromRelativeHref($relative_href) {
		$regex = ',.+/([0-9]+)$,';
		$matches = array();
		preg_match($regex, $relative_href, $matches);
	
		return count($matches) > 0 ? $matches[1] : 0;
	}
}

?>