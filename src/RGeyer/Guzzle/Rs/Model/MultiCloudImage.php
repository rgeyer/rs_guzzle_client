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

use RGeyer\Guzzle\Rs\Model\ModelBase;
use BadMethodCallException;

class MultiCloudImage extends ModelBase {
	
	public function __construct($mixed = null) {
		$this->_path = 'multi_cloud_image';
		$this->_base_params = array('name' => $this->castToString());
		
		parent::__construct($mixed);
	}
	
	public function create($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement a create method");
	}
	
	public function update($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement an update method");
	}
	
	public function destroy() {
		throw new BadMethodCallException($this->_path . " does not implement a destroy method");
	}
	
	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}
	
}

?>