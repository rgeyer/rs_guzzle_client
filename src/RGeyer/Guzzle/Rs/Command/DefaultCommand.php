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

namespace RGeyer\Guzzle\Rs\Command;

use Guzzle\Service\Command\AbstractCommand;
use Guzzle\Http\QueryString;

/**
 * A generic command which hacks together the right path and adds
 * the API version header to any command specified.
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 * @guzzle path doc="The path for the command. Appended to <base_url>/api/acct/{acct_num}/" required="true" type="string"
 *
 */
class DefaultCommand extends AbstractCommand {

  /**
   * @var array An array of parameters which won't be included in the request,
   * but which may impact the behavior of the command.
   */
  protected $_disposable_parameters = array(
    'path' => null,
    'method' => null,
    'headers' => null,
    'return_class' => null
  );

  /**
   * @param array $params An array of parameters which won't be included in the request,
   * but which may impact the behavior of the command.
   */
  public function setDisposableParameters($params = array()) {
    $this->_disposable_parameters = $params;
  }

  public function getDisposableParameters() {
    return $this->_disposable_parameters;
  }

	/**
	 * (non-PHPdoc)
	 * @see Guzzle\Service\Command.AbstractCommand::build()
	 */
	protected function build() {
		$args = $this->getApiCommand()->getParams();
		foreach($args as $arg) {
			if($arg->getLocation() && $arg->getLocation() == 'path') {
				$this->_disposable_parameters += array($arg->getName() => null);
			}
		}
		
		$remainder = array_diff_key($this->getAll(), $this->_disposable_parameters);
    // TODO: Maybe limit this to only params which are defined in the *.xml file?
    // Maybe with an overridable "strict" mode?
		
		$path_prefix = $this->getClient()->getConfig('version') == '1.0' ? '/api/acct/{acct_num}/' : '/api/';
		
		$path = $this->get('path');
		$query_str = new QueryString();
		$post_fields = array();

		foreach($remainder as $key => $value) {
			if(empty($value)) { continue; }
			if(is_array($value)) {
				foreach($value as $ary_key => $ary_value) {												
					$query_str->add($key . "[]", $ary_value);
					if(is_int($ary_key)) {
						$post_fields[$key . "[]"] = $ary_value;
					} else {
						$post_fields[$key . "[$ary_key]"] = $ary_value;
					}
				}
			} else {
				$query_str->add($key, $value);
				$post_fields[$key] = $value;
			}
		}
		
		switch ($this->get('method')) {
			case 'GET':
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
				$this->request = $this->client->get($path_prefix);
				$this->request->setPath($this->request->getPath() . $path . $query_str);
				break;
			case 'POST':
				$this->request = $this->client->post($path_prefix . $path, null, $post_fields);
				break;
			case 'DELETE':
				$this->request = $this->client->delete($path_prefix . $path);
				break;
			case 'PUT':
				$body = new QueryString();
				$body->merge($post_fields);
				$body->setPrefix('');				
				$this->request = $this->client->put($path_prefix . $path, null, $body);
				$this->request->setHeader('Content-Type', 'application/x-www-form-urlencoded');
				break; 
		}
		
		$this->request->setHeader('X-API-VERSION', $this->client->getVersion());
	}
	
	/**
	 * Gets the result of a concrete command
	 * (non-PHPdoc)
	 * @see Guzzle\Service\Command.AbstractCommand::getResult()
	 * 
	 * @return mixed A Guzzle Response unless a return_class was specified in the XML dynamic commands definition
	 */
	public function getResult() {
		$result = parent::getResult();
		if($this->get('return_class')) {
			$classname = $this->get('return_class'); 
			$result = new $classname($result);
		}
		return $result;		
	}
	
	/**
	 * Create the result of the command after the request has been completed.
	 * 
	 * Different from the overridden method in that it properly detects the 1.5 API content type
	 * 'application/vnd.rightscale.cloud+xml' as XML, and it does NOT silently ignore XML parsing errors
	 * 
	 * TODO: Not sure what exceptions (if any) get thrown, but the original implemenation eats them with
	 * a try/catch with no handling in the catch.
	 * 
	 * (non-PHPdoc)
	 * @see Guzzle\Service\Command.AbstractCommand::process()
	 * 
	 * @throws Exception
	 */
	protected function process() {
		$this->result = $this->getRequest()->getResponse();
		
		// Is the body an XML document?  If so, set the result to be a SimpleXMLElement
		if (preg_match('/^\s*(text\/xml|application\/.*xml).*$/', $this->result->getContentType())) {
			// If the body is available, then parse the XML
			$body = trim($this->result->getBody(true));
			if ($body) {
				$xml = new \SimpleXMLElement($body);
				$this->result = $xml;
			}
		}
	}
	
}

?>