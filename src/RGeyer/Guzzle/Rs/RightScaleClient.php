<?php
// Copyright 2011-2013 Ryan J. Geyer
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
use Guzzle\Http\QueryString;

use RGeyer\Guzzle\Rs\IndiscriminateArrayCookieJar;

class RightScaleClient extends Client {

  /**
   * @var string RightScale Account Number
   */
	protected $acct_num;

  /**
   * @var string RightScale user email address for authentication
   */
	protected $email;

  /**
   * @var string RightScale user password for authentication
   */
	protected $password;

  /**
   * @see http://support.rightscale.com/12-Guides/03-RightScale_API/OAuth
   * @var string RightScale OAuth refresh token
   */
  protected $oauth_refresh_token;

  /**
   * @var string The version of the RightScale API to use.  One of ["1.0", "1.5"]
   */
	protected $version;

  /**
   * @var IndiscriminateArrayCookieJar
   */
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
   * @return array An associative array (hash) with authentication details.
   * If oauth_refresh_token is set for the client, the hash will only contain
   * the oauth_refresh_token.  Otherwise it will contain the email address and password.
   */
  public function getAuthenticationDetails() {
    $retval = array('acct_num' => $this->acct_num);

    if($this->oauth_refresh_token) {
      $retval['oauth_refresh_token'] = $this->oauth_refresh_token;
    } else {
      $retval['email'] = $this->email;
      $retval['password'] = $this->password;
    }
    return $retval;
  }
	
	/**
	 * Factory method to create a new RightScaleClient
   *
   * Either an oauth_refresh_token or an email/password pair must be supplied for authentication.
   * If both are supplied the oauth token is preferred
	 *
	 * @param array|Collection $config Configuration data. Array keys:
   *     base_url - * Base URL of RightScale API defaults to 'https://my.rightscale.com'
   *     acct_num - * RightScale account number
   *     oauth_refresh_token - RightScale OAuth API Token for authentication
   *     email - RightScale user email address for authentication
   *     password - RightScale user password for authentication
   *     version - * The version of the RightScale API to use.  One of ["1.0", "1.5"], defaults to "1.0"
	 *
	 * @return RightScaleClient
	 */
	public static function factory($config = array()) {
		$default = array(
      'base_url' => 'https://my.rightscale.com/',
      'version' => '1.0',
      'curl.CURLOPT_FOLLOWLOCATION' => false,
      'curl.CURLOPT_RETURNTRANSFER' => true
    );
		$required = array ('acct_num', 'base_url', 'version');
		$config = Inspector::prepareConfig ( $config, $default, $required );
		
		$client = new self ( $config->get( 'base_url' ),
			$config->get('acct_num'),
      $config->get('oauth_refresh_token'),
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

    $client->getEventDispatcher()->addSubscriber(new HttpAuthenticationPlugin($client));
    $client->getEventDispatcher()->addSubscriber(new ShardAwarenessPlugin($client));

		return $client;
	}

  /**
   * Instantiates a new RightScaleClient.
   *
   * WARNING: Certain functionality (like the service description, shard awareness, auto
   * authentication, retries on error, etc) will not be available if you simply instantiate
   * using this constructor.
   *
   * Best practice is to use RightScaleClient::factory to instantiate a new RightScaleClient
   *
   * @param string base_url Base URL of RightScale API
   * @param string acct_num RightScale account number
   * @param string oauth_refresh_token RightScale OAuth API Token for authentication
   * @param string email RightScale user email address for authentication
   * @param string password RightScale user password for authentication
   * @param string version The version of the RightScale API to use.  One of ["1.0", "1.5"]
   */
  public function __construct($baseUrl, $acctNum, $oauth_refresh_token, $email, $password, $version)
  {
    parent::__construct($baseUrl);
    $this->acct_num             = $acctNum;
    $this->oauth_refresh_token  = $oauth_refresh_token;
    $this->email 		            = $email;
    $this->password             = $password;
    $this->version 	            = $version;
    $this->getDefaultHeaders()->add('X-API-VERSION', $version);
  }

  /**
   * @return string The version of this instantiated RightScaleClient
   */
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
	 * @return \Guzzle\Service\Command\CommandInterface
	 */
	public function getCommand($name, array $args = array()) {
    /*if($name != 'oauth') {
		  $this->checkAuth();
    }*/

    $command = parent::getCommand($name, $args);
    $this->command_history[] = $command;
		return $command;
	}

  /**
   * Returns a new model of the specified type, which will use this client for making API calls
   *
   * @throws \InvalidArgumentException If a namespace is specified, or if the model does not exist
   * @param $modelName The classname of the model you want to instantiate.  Do NOT include the fully qualified class name with namespace.  E.G. Cloud not \RGeyer\Guzzle\Rs\Model\1.5\Cloud
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

    return $model;
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

  public function __call($method, $params=null) {
    # TODO: Guzzle\Service\Client implements this as well, possibly pass through?
    //$this->checkAuth();
    return new \RGeyer\Guzzle\Rs\Command\DynamicCommandAdapter($method, $params, $this);
  }

  protected function checkAuth() {
    $cookies = $this->cookieJar->all();

		// No login cookies, or they're expired
		if(count($cookies) == 0) {
			if($this->version == "1.0") {
				$request = $this->get('/api/acct/'.$this->acct_num.'/login');
        $request->setAuth($this->email, $this->password);
			} else {
				$request = $this->post('/api/session', null, array('email' => $this->email, 'password' => $this->password, 'account_href' => '/api/accounts/' . $this->acct_num));
			}
			$request->setHeader('Accept', '*/*');
			$request->send();
			if($request->getResponse()->getStatusCode() == 302) {
			  $location = strval($request->getResponse()->getHeader('Location'));
        $baseUrl = str_replace('api/session', '', $location);
			  $this->setBaseUrl($baseUrl);
			  $request->setUrl($location);
			  $request->send();
			}
		}
  }

  public function decorateRequest($method, $uri, $params, &$request) {
    $query_str = new QueryString();
    $version_uri_prefix = $this->getConfig('version') == '1.0' ? '/api/acct/'.$this->acct_num.'/' : '/api/';
    $full_uri = $version_uri_prefix . $uri;

    $formatted_params = array();
    $duplicate_array_params = '';

    foreach($params as $key => $value) {
      if($value === null || (!is_int($value) & !is_bool($value) & empty($value))) {continue;}
      if(is_array($value)) {
        foreach($value as $ary_key => $ary_value) {
          if(is_int($ary_key)) {
            if(is_array($ary_value)) {
              foreach($ary_value as $multikey => $multival) {
                $duplicate_array_params .= sprintf('&%s[][%s]=%s', $key, $multikey, rawurlencode($multival));
              }
            } else {
              $formatted_params[$key."[]"] = $value;
              break;
            }
          } else {
            $formatted_params[$key."[$ary_key]"] = $ary_value;
          }
        }
      } else {
        if(is_bool($value)) {
          $formatted_params[$key] = $value ? 'true' : 'false';
        } else {
          $formatted_params[$key] = $value;
        }
      }
    }
    $query_str->merge($formatted_params);
    $query_str->setEncodeFields(false);
    $query_str->setAggregateFunction(
      function($key, $values, $encodeFields = false, $encodeValues = false) {
        $retval = array();
        foreach($values as $value) {
          if(count($retval) == 0) {
            $retval[] = ($encodeValues ? rawurlencode($value) : $value);
          } else {
            $retval[] = ($encodeFields ? rawurlencode($key) : $key) . "=" . ($encodeValues ? rawurlencode($value) : $value);
          }
        }
        return array(($encodeFields ? rawurlencode($key) : $key) => implode('&', $retval));
      }
    );

    switch ($method) {
      case 'GET':
        $request = $this->get($full_uri);
        $request->setPath($full_uri . $query_str . $duplicate_array_params);
        break;
      case 'POST':
        $query_str->setPrefix('');
        $request = $this->post($full_uri, null, strval($query_str).$duplicate_array_params);
        $request->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        break;
      case 'DELETE':
        $request = $this->delete($full_uri);
        break;
      case 'PUT':
        $query_str->setPrefix('');
        $request = $this->put($full_uri, null, strval($query_str).$duplicate_array_params);
        $request->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        break;
    }
  }
}