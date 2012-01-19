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

namespace Guzzle\Rs\Model;

use Guzzle\Rs\Common\ClientFactory;
use DateTime;
use \InvalidArgumentException;
use BadMethodCallException;
use ReflectionClass;
use ReflectionProperty;

/**
 * TODO Create "these values required unless this value set" functionality.
 * I.E. server_template[multi_cloud_image_href] || multi_cloud_image_model || (server_template[ec2_image_href] & server_template[aki_image_href] & server_template[ari_image_href] & server_template[instance_type] & server_template[ec2_user_data])
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 */
abstract class ModelBase {
	
	protected $_path;
	protected $_path_for_regex;
	
	protected $_allowed_params;
	protected $_required_params = array();
	protected $_optional_params = array();	
	protected $_base_params = array();
	
	// Protected attributes with public accessors
	protected $_params = array();
	protected $_client;	
	protected $_last_command;
	
	/* ----------------------- Conversion Closures ----------------------- */	
	protected function castToString() {
		return function($value, $params) { return (string)$value; };
	}
	
	protected function castToInt() {
		return function($value, $params) { return intval($value); };
	}
	
	protected function castToFloat() {
		return function($value, $params) { return floatval($value); };
	}
	
	protected function castToBool() {
		return function($value, $params) { return (bool)$value; };
	}
	
	protected function castToDateTime() {
		return function($value, $params) { return new DateTime($value); };
	}
	
	/* ---------------------------- Overrides ---------------------------- */
	
	public function __construct($mixed = null) {		
		$this->_client = ClientFactory::getClient();
		
		
		if(!$this->_path_for_regex) {
			$this->_path_for_regex = $this->_path . 's';
		}
		
		$this->_base_params = array_merge($this->_base_params, array(
				'id' 								=> $this->castToInt(),
				'href'							=> $this->castToString(),
				'created_at' 				=> $this->castToDateTime(),
				'updated_at' 				=> $this->castToDateTime(),
				'tags' 							=> null,
				'is_head_version' 	=> $this->castToBool(),
				'version'						=> $this->castToInt()
			)
		);
		
		$this->initialize($mixed);
	}
	
	/**
	 * Returns parameters from the parameter array for this object when requested as a property
	 * 
	 * @param string $name The name of the parameter 
	 * @throws InvalidArgumentException If the parameter is not defined for the concrete object.
	 * 
	 * @return mixed The requested parameter (if it exists).
	 */
	public function __get($name) {
		$allowed_params = array_keys($this->_getAllowedParams());
		$array_idx = $name;
		$found = false;
		$found |= $this->_valueInArray($name, $allowed_params, &$array_idx);
		$found |= $this->_valueInArray($this->_path . "[" . $name . "]", $allowed_params, &$array_idx);
	
		if(!$found) {
			throw new InvalidArgumentException("Can not get property $name, it is not defined for this object. Type: " . get_class($this));
		}
	
		return in_array($array_idx, array_keys($this->_params)) ? $this->_params[$array_idx] : '';
	}
	
	public function __set($name, $value) {
		$allowed_params = array_keys($this->_getAllowedParams());
		$array_idx = $name;
		$found = false;
		$found |= $this->_valueInArray($name, $allowed_params, &$array_idx);
		$found |= $this->_valueInArray($this->_path . "[" . $name . "]", $allowed_params, &$array_idx);
		// XML Response can't have dashes
		$found |= $this->_valueInArray(str_replace('-', '_', $name), $allowed_params, &$array_idx);
		$found |= $this->_valueInArray($this->_path . "[" . str_replace('-', '_', $name) . "]", $allowed_params, &$array_idx);
	
		if(!$found) {
			throw new InvalidArgumentException("Can not set property $name, it is not defined for this object. Type: " . get_class($this));
		}
	
		$this->_params[$array_idx] = $value;
	}
	
	/* ---------------------------- Accessors ---------------------------- */
	
	/**
	 * @return array
	 */
	public function getParameters() {
		return $this->_params;
	}
	
	/**
	 * @return RightScaleClient
	 */
	public function getClient() {
		return $this->_client;
	}
	
	public function setClient($client) {
		$this->_client = $client;
	}
	
	public function getLastCommand() {
		return $this->_last_command;
	}
	
	/* ----------------------------- Actions ----------------------------- */
	
	public function index() {
		$results = $this->executeCommand($this->_path_for_regex);
		
		if(!is_a($results, 'SimpleXMLElement')) {
			// Assuming it's a json bodied response
			$results = json_decode($results->getBody(true));
		}
		
		$klass = get_called_class();
		$result_ary = array();
		
		foreach($results as $result) {
			$result_ary[] = new $klass($result);
		}
		
		return $result_ary;
	}
	
	public function find_by_id($id) {
		$result = $this->executeCommand($this->_path, array('id' => $id));
		
		$this->initialize($result);
	}	
	
	/**
	 * 
	 * @param unknown_type $params
	 * 
	 */
	public function create($params = null) {
		if(!$params) { $params = $this->_params; }
		
		$supplied_require_params = array_intersect(array_keys($this->_required_params), array_keys($params));				
		if(count($supplied_require_params) != count($this->_required_params)) {
			throw new InvalidArgumentException("The following required param(s) were not supplied -- " . join(',', array_diff(array_keys($this->_required_params), array_keys($params))));
		}
		
		$allowed_params = array_keys($this->_getAllowedParams());
		if(count(array_diff(array_keys($params), $allowed_params)) > 0) {
			throw new InvalidArgumentException("The following parameters are invalid -- " . join(',', array_diff(array_keys($params), $allowed_params)));
		}
		
		$result = $this->executeCommand($this->_path_for_regex . "_create", $params);
		$this->initialize($result);
	}
	
	public function update($params = null) {
		if(!$params) { $params = $this->_params; }
		
		if(!$this->id || !$this->href) {
			throw new BadMethodCallException("This object has not yet been created, and therefore can not be updated.  Try the ->create() method first");
		}
		
		$allowed_params = $this->_getAllowedParams();
		$allowed_keys = array_keys($allowed_params);
		if(count(array_diff(array_keys($params), $allowed_keys)) > 0) {
			throw new InvalidArgumentException("The following parameters are invalid -- " . join(',', array_diff(array_keys($params), $allowed_keys)));
		}
		
		$result = $this->executeCommand($this->_path_for_regex . "_create", $params);		
	}
	
	public function destroy() {
		$params = array('id' => $this->id);
		$result = $this->executeCommand($this->_path_for_regex . '_destroy', $params);
		return $result;		
	}
	
	public function duplicate() {
		$params = array('id' => $this->id);
		$result = $this->executeCommand($this->_path_for_regex . '_duplicate', $params);
		return $result;
	}
	
	/* ----------------------- Protected Utilities ----------------------- */
	
	protected function initialize($mixed) {
								
		if(is_a($mixed, 'Guzzle\Http\Message\Response')) {			
			$this->href = $mixed->getHeader('Location');
			
			$json_obj = json_decode($mixed->getBody(true));
			if($json_obj) {
				$this->_castInputParametersWithClosure($json_obj);
			}			
		}
		
		if(is_a($mixed, 'SimpleXMLElement')) {			
			$this->_castInputParametersWithClosure(get_object_vars($mixed));
		}
		
		if(is_a($mixed, 'stdClass')) {
			$this->_castInputParametersWithClosure(get_object_vars($mixed));
		}
		
		if(is_a($mixed, 'Guzzle\Rs\Model\ModelBase')) {
			$this->_params = $mixed->_params;
		}
		
		if($this->href) {
			$this->id = intval($this->getIdFromHref($this->href));
		}
	}
	
	protected function getIdFromHref($href) {
		$regex = ',https://.+/api/acct/[0-9]+/' . preg_quote($this->_path_for_regex) . '/([0-9]+),';
		$matches = array();
		preg_match($regex, $href, $matches);
		
		return $matches[1];
	}
	
	protected function executeCommand($command, array $params = array()) {
		$this->_last_command = $this->_client->getCommand($command, $params);
		$this->_last_command->execute();
		
		return $this->_last_command->getResult();		
	}
	
	/* ------------------------ Private Utilities ------------------------ */
	
	private function _castInputParametersWithClosure($params) {
		$allowed_params = $this->_getAllowedParams();		
		foreach($params as $name => $value) {
			$array_idx = $name;
			$found = false;
			$found |= $this->_valueInArray($name, array_keys($allowed_params), &$array_idx);
			$found |= $this->_valueInArray($this->_path . "[" . $name . "]", array_keys($allowed_params), &$array_idx);
			// XML Response can't have dashes
			$found |= $this->_valueInArray(str_replace('-', '_', $name), array_keys($allowed_params), &$array_idx);
			$found |= $this->_valueInArray($this->_path . "[" . str_replace('-', '_', $name) . "]", array_keys($allowed_params), &$array_idx);
	
			$closure = $allowed_params[$array_idx];
			$this->$array_idx = $closure ? $closure($value, $params) : $value;
		}
	}
	
	private function _valueInArray($value, $array, &$setValue = null) {
		$in_array = in_array($value, $array);
		if($in_array && $setValue) {
			$setValue = $value;
		}
		return $in_array;
	}
	
	private function _getAllowedParams() {
		if(!$this->_allowed_params) {
			$this->_allowed_params = array_merge($this->_required_params, $this->_optional_params, $this->_base_params);
		}
		return $this->_allowed_params;
	}
}

?>