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
use BadMethodCallException;

/**
 * A model for the RightScale ServerTemplate Resource in v1.5 of the API
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * @property array $inputs An array of the inputs defined by the scripts associated with this ServerTemplate
 * @property string $description
 * @property string $name
 * @property integer $revision
 *
 * @method stdClass publication() A single publication object from which this ServerTemplate originates
 */
class ServerTemplate extends ModelBase {

	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'server_template';
		$this->_required_params = array(
	    'server_template[name]' => $this->castToString()
    );
		$this->_optional_params = array(
	    'server_template[description]' => $this->castToString()
    );
		$this->_base_params = array(
			'inputs' => null,
			'revision' => $this->castToInt()
		);
		
		$this->_relationship_handlers = array(
		  'publication' => 'publication'
	  );
		
		parent::__construct($mixed);
	}

	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}
}