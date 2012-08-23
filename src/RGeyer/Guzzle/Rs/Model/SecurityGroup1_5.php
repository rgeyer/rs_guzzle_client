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

namespace RGeyer\Guzzle\Rs\Model;

use RGeyer\Guzzle\Rs\Model\ModelBase;
use BadMethodCallException;

class SecurityGroup1_5 extends ModelBase {

	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'security_group';
		$this->_required_params = array('security_group[name]' => $this->castToString(), 'cloud_id' => $this->castToInt());
		$this->_optional_params = array('security_group[description]' => $this->castToString());
		$this->_base_params = array(
				'resource_uid' => $this->castToString()
		);

		parent::__construct($mixed);
	}

	public function update($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement an update method");
	}

	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}

}