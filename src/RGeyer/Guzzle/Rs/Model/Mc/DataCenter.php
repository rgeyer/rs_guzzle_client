<?php
// Copyright 2012 Ryan J. Geyer
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

namespace RGeyer\Guzzle\Rs\Model\Mc;

use RGeyer\Guzzle\Rs\Model\ModelBase;
use \BadMethodCallException;

/**
 * A model for the RightScale DataCenter Resource in v1.5 of the API
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * @property string $resource_uid
 * @property string $description
 * @property string $name
 */
class DataCenter extends ModelBase {
	
	/**
	 * Creates a new DataCenter object.
	 * 
	 * @param mixed $mixed
	 */
	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'datacenter';
		$this->_base_params = array(
      'resource_uid' => $this->castToString(),
      'name' => $this->castToString(),
      'description' => $this->castToString()
    );

    $this->_path_requires_cloud_id = true;
    $this->_id_is_alphanumeric = true;

    $this->_relationship_handlers = array(
      'cloud' => 'cloud'
    );
		
		parent::__construct($mixed);
	}
	
	public function create($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement a create method");
	}
	
	public function update($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement an update method");
	}
	
	public function destroy($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement a destroy method");
	}
	
	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}
}