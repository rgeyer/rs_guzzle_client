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
   * @var array The history of commands made by this client
   */
  protected $command_history;

  /**
   * Removes the latest $count commands from the command history using array_pop and returns them
   *
   * @param int $count The number of previous commands to return
   * @return array One or more of the last commands
   */
  public function getLastCommand($count = 1) {
    $retval = array();
    for($i = 0; $i < $count; $i++) {
      $retval[] = array_pop($this->command_history);
    }
    return $retval;
  }
	
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
        //$client->getEventDispatcher()->addSubscriber(new ExponentialBackoffPlugin());

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
			$request->setHeader('Accept', '*/*');
			$request->setHeader('X-API-VERSION', $this->version);
			$request->send();
			if($request->getResponse()->getStatusCode() == 302) {
			  $location = $request->getResponse()->getHeader('Location');
			  $this->setBaseUrl(str_replace('api/session/', '', $location));
			  $request->setUrl($location);
			  $request->send();
			}
		}

    $command = parent::getCommand($name, $args);
    $this->command_history[] = $command;
		return $command;
	}

  /**
   * Returns a new model of the specified type, which will use this client for making API calls
   *
   * @throws \InvalidArgumentException If a namespace is specified, or if the model does not exist
   * @param $modelName The classname of the model you want to instantiate.  Do NOT include the fully qualified class name with namespace.  E.G. Cloud
   * @param mixed $mixed Any of the acceptable parameter types for ModelBase::__construct
   * @return \RGeyer\Guzzle\Rs\ModelBase A model object of the type specified in $modelName
   */
  public function newModel($modelName, $mixed = null) {
    if(substr_count("\\", $modelName) > 0) {
      throw new InvalidArgumentException("Do not provide the full namespace plus classname of the desired model.  Only the model classname is required.  E.G. Cloud");
    }

    $prefix = $this->version == '1.0' ? 'Ec2\\' : 'Mc\\';

    $modelName = "\\RGeyer\\Guzzle\\Rs\\Model\\" . $prefix . $modelName;

    if(!class_exists($modelName)) {
      throw new \InvalidArgumentException("The model $modelName does not exist");
    }

    $model = new $modelName($mixed);
    $model->setClient($this);

    return new $modelName();
  }

	/**
	 * Returns the object id when given the objects basename and it's href.
	 *
   * @static
	 * @example RightScaleClient::getIdFromHref('credentials', 'https://my.rightscale.com/api/acct/12345/credentials/12345');
	 * @param string $basename The name of the object as it appears in the URL.  I.E. For Credentials it is "credentials" since the URL looks like https://my.rightscale.com//api/acct/12345/credentials/12345
	 * @param string $href The full API href of the object.  I.E. https://my.rightscale.com/api/acct/12345/credentials/12345
	 *
	 * @return integer The ID of the object
	 */
	public static function getIdFromHref($basename, $href) {
		$regex = ',https://.+/api/acct/[0-9]+/' . $basename . '/([0-9]+),';
		$matches = array();
		preg_match($regex, $href, $matches);

		return count($matches) > 0 ? $matches[1] : 0;
	}

	/**
	 * Returns the object id when given the objects relative href.
	 *
   * @static
	 * @example RightScaleClient::getIdFromRelativeHref('/api/clouds/12345');
	 * @param string $href The relative API href of the object.  I.E. /api/clouds/12345
	 *
	 * @return integer The ID of the object
	 */
	public static function getIdFromRelativeHref($relative_href) {
		$regex = ',.+/([0-9A-Z]+)$,';
		$matches = array();
		preg_match($regex, $relative_href, $matches);

		return count($matches) > 0 ? $matches[1] : 0;
	}

  /**
   * Returns an href in the relative 1.5 format of /api/resource/id rather than the full URI from 1.0 https://my.rightscale.com/api/acct/acct_id/resource/id
   *
   * @static
   * @param $href The full 1.0 resource URI
   * @return mixed The relative 1.5 API href
   */
	public static function convertHrefFrom1to15($href) {
		return preg_replace(',https://my.rightscale.com,', '',
				preg_replace(',/acct/[0-9]*,', '', $href)
		);
	}

	public static function convertStHrefFrom1to15($href) {
		return preg_replace(',ec2_server_templates,', 'server_templates', RightScaleClient::convertHrefFrom1to15($href));
	}
}