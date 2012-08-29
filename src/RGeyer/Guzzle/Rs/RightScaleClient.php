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

namespace RGeyer\Guzzle\Rs;

use Guzzle\Http\Plugin\ExponentialBackoffPlugin;

use Guzzle\Http\Plugin\CookiePlugin;

use Guzzle\Service\Inspector;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

use RGeyer\Guzzle\Rs\IndiscriminateArrayCookieJar;

class RightScaleClient extends Client {
	
	protected $acct_num;
	
	protected $email;
	
	protected $password;
	
	protected $version;
	
	protected $cookieJar;
	
	/**
	 * Factory method to create a new RightScaleClient
	 *
	 * @param array|Collection $config Configuration data. Array keys:
     *     base_url - * Base URL of web service
     *     acct_num - * RightScale account number
     *     email - Email
     *     password - RS password
     *     version - * API version
	 *
	 * @return RightScaleClient
	 *
	 * @TODO update factory method and docblock for parameters
	 */
	public static function factory($config = array()) {
		$default = array ('base_url' => 'https://my.rightscale.com/', 'version' => '1.0');
		$required = array ('acct_num', 'base_url', 'version');
		$config = Inspector::prepareConfig ( $config, $default, $required );
		
		$client = new self ( $config->get( 'base_url' ),
			$config->get('acct_num'),
			$config->get('email'),
			$config->get('password'),
			$config->get('version')
		);
		$client->setConfig ( $config );
		
		// Add the XML service description to the client
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'rs_guzzle_client_v'. $client->getVersion() . '.xml';
    $client->setDescription(ServiceDescription::factory($path));

		// Keep them cookies
		$client->cookieJar = new IndiscriminateArrayCookieJar(); 
        $client->getEventDispatcher()->addSubscriber(new CookiePlugin($client->cookieJar));
		
		// Retry 50x responses
        $client->getEventDispatcher()->addSubscriber(new ExponentialBackoffPlugin());

		return $client;
	}
	
	/**
     * @param string $baseUrl
     * @param string $acctNum
     * @param string $email
     * @param string $password
     * @param string $version
	 */
    public function __construct($baseUrl, $acctNum, $email, $password, $version)
    {
        parent::__construct($baseUrl);
        $this->acct_num = $acctNum;
		$this->email 		= $email;
		$this->password = $password;
		$this->version 	= $version;
	}
	
	public function getVersion() {
		return $this->version;
	}
	
	/**
	 * @return IndiscriminateArrayCookieJar
	 */
	public function getCookieJar() {
		return $this->cookieJar;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Guzzle\Service.Client::getCommand()
	 * 
	 * @return CommandInterface
	 */
	public function getCommand($name, array $args = array()) {
		$cookies = $this->cookieJar->all();
		
		// No login cookies, or they're expired
		if(count($cookies) == 0) {
			if($this->version == "1.0") {
				$request = $this->get('/api/acct/{acct_num}/login');
				$request->setAuth($this->email, $this->password);
			} else {
				$request = $this->post('/api/session', null, array('email' => $this->email, 'password' => $this->password, 'account_href' => '/api/accounts/' . $this->acct_num));
			}
			$request->setHeader('X-API-VERSION', $this->version);
			$request->send();
		}

		return parent::getCommand($name, $args);
	}

  /**
   * Returns a new model of the specified type, which will use this client for making API calls
   *
   * @throws \InvalidArgumentException If a namespace is specified, or if the model does not exist
   * @param $modelName The type (Ec2 or Mc) and classname of the model you want to instantiate.  Do NOT include the fully qualified class name with namespace.  E.G. Mc\Cloud
   * @param mixed $mixed Any of the acceptable parameter types for ModelBase::__construct
   * @return \RGeyer\Guzzle\Rs\ModelBase A model object of the type specified in $modelName
   */
  public function newModel($modelName, $mixed = null) {
    if(substr_count("\\", $modelName) > 1) {
      throw new InvalidArgumentException("Do not provide the full namespace plus classname of the desired model.  Only the model type (Ec2 or Mc) and classname is required.  E.G. Mc\\Cloud");
    }

    $modelName = "\\RGeyer\\Guzzle\\Rs\\Model\\" . $modelName;

    if(!class_exists($modelName)) {
      throw new \InvalidArgumentException("The model $modelName does not exist");
    }

    $model = new $modelName($mixed);
    $model->setClient($this);

    return new $modelName();
  }
}