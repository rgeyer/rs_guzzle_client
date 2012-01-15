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

use Guzzle\Rs\Common\ClientFactory;

class ClientCommandsBase extends \Guzzle\Tests\GuzzleTestCase
{
    protected $_client;
    protected $_testTs;

    protected function setUp()
    {
        parent::setUp();
        $this->_testTs = time();
        $this->_client = $this->getServiceBuilder()->get('test.guzzle-rs-1_0');
    }

    /**
     * Does the heavy lifting of getting and executing a command
     *
     * @param string $commandName The name of the dynamic command specified in the xml file
     * @param array $params The array of parameters for the command
     * @param CommandInterface $command A reference to an object which will get set to the command interface object
     * @param string $variant A description which will become part of the path for the mock request/response files if $_SERVER['HTTP_TRACE'] is set
     *
     * @return mixed Either a CommandInterface or the specific model as defined in the xml file
     */
    protected function executeCommand($commandName, array $params = array(), &$command = null, $variant = null)
    {
        $command = $this->_client->getCommand($commandName, $params);
        $command->execute();
        $result = $command->getResult();

        if ($_SERVER['HTTP_TRACE'] == 'true') {
            $dir = __DIR__ . '/../' . 'mock/' . $this->_client->getConfig('version') . '/' . $commandName;
            $command_params = $command->getAll();
            if (array_key_exists('output_format', $command_params)) {
                $dir .= '/' . str_replace('.', '', $command_params['output_format']);
            }
            if ($variant) {
                $dir .= '/' . $variant;
            }
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            $request_str = $command->getRequest();
            $response_str = $command->getResponse();
            if ($_SERVER['OBFUSCATE_IDS'] == 'true') {
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