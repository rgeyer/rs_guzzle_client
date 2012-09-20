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

namespace RGeyer\Guzzle\Rs\Model;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\RightScaleClient;
use DateTime;
use InvalidArgumentException;
use BadMethodCallException;
use ReflectionClass;
use ReflectionProperty;

/**
 * TODO Create "these values required unless this value set" functionality.
 * I.E. server_template[multi_cloud_image_href] || multi_cloud_image_model || (server_template[ec2_image_href] & server_template[aki_image_href] & server_template[ari_image_href] & server_template[instance_type] & server_template[ec2_user_data])
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * @property int $id The unique identifier of the object in the RightScale API
 * @property string $href The API href of the object in the RightScale API
 * @property DateTime $created_at Creation date of the object
 * @property DateTime $updated_at Last update date of the object
 * @property array $tags A list of tags on the object (not available to all object types)
 * @property bool $is_head_version Boolean indicating head revision for an object
 * @property int $version The current revision/version of the object
 * @property array $links A list of references to related objects in the RightScale API (An API 1.5 extension)
 * @property array $actions
 * @property string $cloud_id The cloud id of the object (An API 1.5 extension)
 */
abstract class ModelBase {

  /**
   * @var string Which RightScale API version to use
   */
	protected $_api_version = '1.0';

  /**
   * @var string The RightScale API path for this model.  I.E. https://my.rightscale.com/api/acct/<path>
   */
	protected $_path;

  /**
   * @var string The name of the object when returned by the API.  This is usually the plural of $_path, but in some cases (like for the ServerTemplates in API 1.0) it is a completely different thing.
   */
	protected $_path_for_regex;

  /**
   * @var array An array of parameters which are permissible for this object. Just-in-time created by ModelBase::_getAllowedParams
   */
	protected $_allowed_params;

  /**
   * @var array An array of parameters which are required for the ModelBase::create and ModelBase::update requests
   */
	protected $_required_params = array();

  /**
   * @var array An array of parameters which are admissible for the ModelBase::create and ModelBase::update requests, but which are not required
   */
	protected $_optional_params = array();

  /**
   * @var array An array of any additional parameters or properties that the object exposes, but which are not input parameters to ModelBase::create or ModelBase::update
   */
	protected $_base_params = array();

  /* ------------ Protected attributes with public accessors ----------- */

  /**
   * @var array The array of all parameters and properties for the object.  Gettable and settable by the "magic" __get and __set calls
   */
	protected $_params = array();

  /**
   * @var RGeyer\Guzzle\Rs\RightScaleClient
   */
	protected $_client;

  /**
   * @var Guzzle\Http\Service\Command\CommandInterface The last command object created by the current client.
   */
	protected $_last_command;

  /**
   * @var bool A boolean indicating if the cloud ID is required in the API request path.  I.E. /api/clouds/:cloud_id/security_groups
   */
  protected $_path_requires_cloud_id = false;

  /**
   * @var bool A boolean indicating if the objects ID is an integer, or alphanumeric string
   */
  protected $_id_is_alphanumeric = false;
	
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
		$this->_client = ClientFactory::getClient($this->_api_version);		
		
		if(!$this->_path_for_regex) {
			$this->_path_for_regex = $this->_path . 's';
		}

    $all_base = array(
      'id' 								=> $this->_id_is_alphanumeric ? $this->castToString() : $this->castToInt(),
      'cloud_id'          => $this->castToString(),
      'href'							=> $this->castToString(),
      'created_at' 				=> $this->castToDateTime(),
      'updated_at' 				=> $this->castToDateTime(),
      'tags' 							=> null,
      'is_head_version' 	=> $this->castToBool(),
      'version'						=> $this->castToInt(),
      'links'							=> null,
      'actions'						=> null
    );
		
		$this->_base_params = array_merge($this->_base_params, $all_base);
		
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
		$found |= $this->_valueInArray($name, $allowed_params, $array_idx);
		$found |= $this->_valueInArray($this->_path . "[" . $name . "]", $allowed_params, $array_idx);
	
		if(!$found) {
			throw new InvalidArgumentException("Can not get property $name, it is not defined for this object. Type: " . get_class($this));
		}
	
		return in_array($array_idx, array_keys($this->_params)) ? $this->_params[$array_idx] : '';
	}
	
	public function __set($name, $value) {
		$allowed_params = array_keys($this->_getAllowedParams());
		$array_idx = $name;
		$found = false;
		$found |= $this->_valueInArray($name, $allowed_params, $array_idx);
		$found |= $this->_valueInArray($this->_path . "[" . $name . "]", $allowed_params, $array_idx);
		// XML Response can't have dashes
		$found |= $this->_valueInArray(str_replace('-', '_', $name), $allowed_params, $array_idx);
		$found |= $this->_valueInArray($this->_path . "[" . str_replace('-', '_', $name) . "]", $allowed_params, $array_idx);
	
		if(!$found) {
			throw new InvalidArgumentException("Can not set property $name, it is not defined for this object. Type: " . get_class($this));
		}
	
		$this->_params[strval($array_idx)] = $value;
	}
	
	/* ---------------------------- Accessors ---------------------------- */
	
	/**
	 * @return array
	 */
	public function getParameters() {
		return $this->_params;
	}
	
	/**
	 * @return Rgeyer\Guzzle\Rs\RightScaleClient
	 */
	public function getClient() {
		return $this->_client;
	}

  /**
   * @param Rgeyer\Guzzle\Rs\RightScaleClient $client A RightScale API guzzle client to use for request
   * @return void
   */
	public function setClient(RightScaleClient $client) {
		$this->_client = $client;
	}

  /**
   * @return Guzzle\Http\Service\Command\CommandInterface The last command object created by the current client.
   */
	public function getLastCommand() {
		return $this->_last_command;
	}
	
	/* ----------------------------- Actions ----------------------------- */
	
	public function index($parentModelOrHref = null) {
		$params = array();
		// TODO: This is a bit hacky, it depends upon a child class having the cloud_id set.
		if($this->_path_requires_cloud_id && array_key_exists('cloud_id', $this->_params)) {
			$params['cloud_id'] = $this->cloud_id;
		}
    if($parentModelOrHref != null) {
      $parent_path = '';

      if($parentModelOrHref instanceof ModelBase) {
        $parent_path = str_replace('/api/', '', $parentModelOrHref->href);
      } else {
        $parent_path = str_replace('/api/', '', $parentModelOrHref);
      }
      $params['path'] = $parent_path . '/' . $this->_path_for_regex . '{output_format}';
    }

		$results = $this->executeCommand($this->_path_for_regex, $params);
		
		if(!is_a($results, 'SimpleXMLElement')) {
			// Assuming it's a json bodied response
			$results = json_decode($results->getBody(true));
		}		
		
		$klass = get_called_class();
		$result_ary = array();
		
		if(count($results) > 0) {
			foreach($results as $result) {
				$result_ary[] = new $klass($result);
			}
		}
		
		return $result_ary;
	}
	
	public function find_by_id($id) {
    $params = array('id' => $this->_castIdWithClosure($id));
    if($this->_path_requires_cloud_id && array_key_exists('cloud_id', $this->_params)) {
			$params['cloud_id'] = $this->cloud_id;
		}
		$result = $this->executeCommand($this->_path, $params);
		
		$this->initialize($result);
	}

	public function find_by_href($href) {
		$id = $this->getIdFromHref($href);
		$this->find_by_id($id);
	}

  /**
   * Calls the "Create" or POST method on the API resource represented by the model.
   *
   * @throws \InvalidArgumentException When invalid parameters are supplied, or when required parameters are ommitted
   * @param array $params An array of paramters to override in the request.  This will be merged with all existing parameters/properties of this object.
   */
	public function create($params = null) {
		if($params) { $this->_params = array_merge($this->_params, $params); }
		
		$supplied_require_params = array_intersect(array_keys($this->_required_params), array_keys($this->_params));
		if(count($supplied_require_params) != count($this->_required_params)) {
			throw new InvalidArgumentException("The following required param(s) were not supplied -- " . join(',', array_diff(array_keys($this->_required_params), array_keys($this->_params))));
		}
		
		$allowed_params = array_keys($this->_getAllowedParams());
		if(count(array_diff(array_keys($this->_params), $allowed_params)) > 0) {
			throw new InvalidArgumentException("The following parameters are invalid -- " . join(',', array_diff(array_keys($this->_params), $allowed_params)));
		}
		
		$result = $this->executeCommand($this->_path_for_regex . "_create", $this->_params);
		$this->initialize($result);
	}

  /**
   * Calls the "Update" or PUT method on the API resource represented by the model.
   *
   * @throws \BadMethodCallException|\InvalidArgumentException If the id or href of the resource in the API is unknown, or if an invalid parameter was supplied.
   * @param array $params An array of paramters to override in the request.  This will be merged with all existing parameters/properties of this object.
   */
	public function update($params = null) {
    if($params) { $this->_params = array_merge($this->_params, $params); }
		
		if(!$this->id || !$this->href) {
			throw new BadMethodCallException("This object has not yet been created, and therefore can not be updated.  Try the ->create() or one of the ->findBy* methods first");
		}

    $this->_params['id'] = $this->_castIdWithClosure();
		
		$allowed_params = $this->_getAllowedParams();
		$allowed_keys = array_keys($allowed_params);
		if(count(array_diff(array_keys($this->_params), $allowed_keys)) > 0) {
			throw new InvalidArgumentException("The following parameters are invalid -- " . join(',', array_diff(array_keys($this->_params), $allowed_keys)));
		}
		
		$result = $this->executeCommand($this->_path_for_regex . "_update", $this->_params);
	}
	
	public function destroy() {
		$params = array('id' => $this->id);
    if($this->_path_requires_cloud_id && array_key_exists('cloud_id', $this->_params)) {
			$params['cloud_id'] = $this->cloud_id;
		}
		$result = $this->executeCommand($this->_path_for_regex . '_destroy', $params);
		return $result;		
	}
	
	public function duplicate() {
		$params = array('id' => $this->id);
    if($this->_path_requires_cloud_id && array_key_exists('cloud_id', $this->_params)) {
			$params['cloud_id'] = $this->cloud_id;
		}
		$result = $this->executeCommand($this->_path_for_regex . '_duplicate', $params);
		return $result;
	}
	
	/* ----------------------- Protected Utilities ----------------------- */
	
	protected function initialize($mixed) {
								
		if(is_a($mixed, 'Guzzle\Http\Message\Response')) {			
			$this->href = strval($mixed->getHeader('Location'));
			
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
		
		if(is_a($mixed, 'RGeyer\Guzzle\Rs\Model\ModelBase')) {
			$this->_params = array_merge($this->_params, $mixed->_params);
		}
		
		if(isset($this->_params['links'])) {
			foreach($this->links as $link) {
				if($link->rel == 'self') {
					$this->href = $link->href;
				}
			}
		}
		
		if($this->href) {
			$this->id = $this->_castIdWithClosure($this->getIdFromHref($this->href));
		}
	}
	
	protected function getIdFromHref($href) {
		switch($this->_api_version) {
			case '1.0':		
				$regex = ',https://.+/api/acct/[0-9]+/' . preg_quote($this->_path_for_regex) . '/([0-9]+),';
				break;
			case '1.5':
				$regex = ',.+/([0-9A-Z]+)$,';
		}
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
			$found |= $this->_valueInArray($name, array_keys($allowed_params), $array_idx);
			$found |= $this->_valueInArray($this->_path . "[" . $name . "]", array_keys($allowed_params), $array_idx);
			// XML Response can't have dashes
			$found |= $this->_valueInArray(str_replace('-', '_', $name), array_keys($allowed_params), $array_idx);
			$found |= $this->_valueInArray($this->_path . "[" . str_replace('-', '_', $name) . "]", array_keys($allowed_params), $array_idx);

      if($found) {
        $closure = $allowed_params[$array_idx];
        $this->$array_idx = $closure ? $closure($value, $params) : $value;
      }
      if($array_idx == 0) {
        //print_r($params);
      }
		}
	}

  private function _castIdWithClosure($id = null) {
    if($id == null) {
      $id = $this->id;
    }
    $id_closure = $this->_base_params['id'];
    return $id_closure($id, array('id' => $id));
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