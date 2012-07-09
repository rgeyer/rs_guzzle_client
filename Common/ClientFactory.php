<?php
// Copyright 2011 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
// http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.


namespace Guzzle\Rs\Common;

use Guzzle\Rs\RightScaleClient;
use Guzzle\Service\ServiceBuilder;
use InvalidArgumentException;

/**
 * A static singleton for creating a Guzzle ServiceBuilder and keeping it around to serve up the
 * same set of RightScaleClient object(s)
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 */
class ClientFactory {
	protected static $_builder;
	
	public static $_acct_num 	= null;
	public static $_email 		= null;
	public static $_password 	= null;

	public static $_additionalParams = array();

	/**
	 * Lazy loads the builder singleton.  Requires that ClientFactory::setCredentials has been previously
	 * called and valid credentials have been given.
	 * 
	 * @throws \InvalidArgumentException When no credentials are set
	 * 
	 * @return ServiceBuilder
	 */
	protected static function getBuilder() {
		if((!ClientFactory::$_acct_num) || (!ClientFactory::$_email) || (!ClientFactory::$_password)) {
			// @codeCoverageIgnoreStart
			throw new InvalidArgumentException("No RightScale API credentials supplied, please call ClientFactory::setCredentials first.");
			// @codeCoverageIgnoreEnd
		}
		
		if (!ClientFactory::$_builder) {

			ClientFactory::$_builder = ServiceBuilder::factory(array(
					'guzzle-rs-1_0' => array (
							'class' => 'Guzzle\Rs\RightScaleClient',
							'params' => array_merge(array(
									'acct_num' 	=> ClientFactory::$_acct_num,
									'email' 		=> ClientFactory::$_email,
									'password' 	=> ClientFactory::$_password,
									'version' 	=> '1.0'
									), ClientFactory::$_additionalParams
							)
					),
					'guzzle-rs-1_5' => array (
							'class' => 'Guzzle\Rs\RightScaleClient',
							'params' => array_merge(array(
									'acct_num' 	=> ClientFactory::$_acct_num,
									'email' 		=> ClientFactory::$_email,
									'password' 	=> ClientFactory::$_password,
									'version' 	=> '1.5'
									), ClientFactory::$_additionalParams
							)
					)
			));
		}
		
		return ClientFactory::$_builder;
	}
	
	// @codeCoverageIgnoreStart
	/**
	 * Sets the credentials to use for any client produced from this factory
	 * 
	 * @param string $acct_num Your RightScale account number
	 * @param string $email Your RightScale account email
	 * @param string $password Your RightScale account password
	 */
	public static function setCredentials($acct_num, $email, $password) {
		ClientFactory::$_acct_num = $acct_num;
		ClientFactory::$_email 		= $email;
		ClientFactory::$_password = $password;
	}
	// @codeCoverageIgnoreEnd

	/**
	 * Sets additional parameters (e.g. curl options) to use for any client produced from this factory
	 *
	 * @param array $params array with additional parameters, key is parameter name, value - parameter value
	 */
	public static function setAdditionalParams($params) {
		ClientFactory::$_additionalParams = $params;
	}

	/**
	 * Returns a persistent instance of the Guzzle RightScaleClient.
	 * 
	 * @param string $version The API version of the returned client, currently acceptable options are "1.0" and "1.5"
	 * 
	 * @throws \InvalidArgumentException When the version is not 1.0 or 1.5, or when no credentials are set.
	 * 
	 * @return RightScaleClient
	 */
	public static function getClient($version = "1.0") {
		$acceptable_versions = array('1.0', '1.5');
		
		if(!in_array($version, $acceptable_versions)) {
			throw new InvalidArgumentException("API Version $version is not supported, please try 1.0 or 1.5");
		}
		
		$version = str_ireplace('.', '_', $version);
		
		return ClientFactory::getBuilder()->get( "guzzle-rs-$version" );
	}

}

?>