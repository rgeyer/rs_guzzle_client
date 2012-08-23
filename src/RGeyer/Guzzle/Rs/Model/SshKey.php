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
use RGeyer\Guzzle\Rs\Common\ClientFactory;
use BadMethodCallException;

class SshKey extends ModelBase {
	
	public function __construct($mixed = null) {		
		$this->_path = 'ec2_ssh_key';
		$this->_required_params = array('ec2_ssh_key[aws_key_name]' => $this->castToString());
		$this->_optional_params = array('cloud_id' => $this->castToInt());
		$this->_base_params = array('aws_fingerprint' => $this->castToString(), 'aws_material' => $this->castToString());

		parent::__construct($mixed);
	}
	
	protected function initialize($mixed) {

		parent::initialize($mixed);
	}
	
	public function index() {
		throw new BadMethodCallException($this->_path . " does not implement a list method");
	}

	public function update($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement an update method");
	}

	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}
}

?>