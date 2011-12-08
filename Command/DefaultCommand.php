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

namespace Guzzle\Rs\Command;

use Guzzle\Service\Command\AbstractCommand;
use Guzzle\Http\QueryString;

/**
 * A generic command which hacks together the right path and adds
 * the API version header to any command specified.
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 * @guzzle path doc="The path for the command. Appended to <base_url>/api/acct/{{acct_num}}/" required="true" type="string"
 *
 */
class DefaultCommand extends AbstractCommand {

	/**
	 * (non-PHPdoc)
	 * @see Guzzle\Service\Command.AbstractCommand::build()
	 */
	protected function build() {		
		$disposable = array('path' => null, 'method' => null, 'headers' => null, 'return_class' => null);
		$remainder = array_diff_key($this->getAll(), $disposable);
		
		$path = $this->get('path');
		$query_str = '?';
		$post_fields = array();
		
		// Take the remaining ones and see if they match any tokens in the path string
		foreach($remainder as $key => $value) {
			if (empty($value) || !strstr($path, (is_array($value) ? ' ' : $value))) {
				if(is_array($value))
				{
					foreach($value as $ary_key => $ary_value) {												
						$query_str .= $key . "%5B%5D=$ary_value&";
						if(is_int($ary_key)) {
							$post_fields[$key . "[]"] = $ary_value;
						} else {
							$post_fields[$key . "[$ary_key]"] = $ary_value;
						}
					}
				} else {
					$query_str .= "$key=$value&";
					$post_fields[$key] = $value;
				}
			}
		}
		
		switch ($this->get('method')) {
			case 'GET':
				$this->request = $this->client->get('/api/acct/{{acct_num}}/');
				$this->request->setPath($this->request->getPath() . $path . $query_str);
				break;
			case 'POST':
				$this->request = $this->client->post('/api/acct/{{acct_num}}/' . $path, null, $post_fields);
				break;
			case 'DELETE':
				$this->request = $this->client->delete('/api/acct/{{acct_num}}/' . $path);
				break;
			case 'PUT':
				$body = new QueryString();
				$body->merge($post_fields);
				$body->setPrefix('');				
				$this->request = $this->client->put('/api/acct/{{acct_num}}/' . $path, null, $body);
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
	
}

?>