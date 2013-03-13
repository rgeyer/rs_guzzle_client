<?php
// Copyright 2013 Ryan J. Geyer
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
 * A model for the RightScale Deployment Resource in v1.5 of the API
 *
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * @property string $name
 * @property string $description
 * @property string $server_tag_scope
 * @property array $inputs
 *
 * @method array inputs($params = null) A list of inputs belonging to this deployment
 * @method array server_arrays($params = null) A list of server arrays belonging to this deployment
 * @method array servers($params = null) A list of servers belonging to this deployment
 */
class Deployment extends ModelBase {

  public function __construct($mixed = null) {
    $this->_api_version = '1.5';

    $this->_path = 'deployment';
    $this->_base_params = array(
      'name' => $this->castToString(),
      'description' => $this->castToString(),
      'server_tag_scope' => $this->castToString(),
      'inputs' => null
    );

    $this->_relationship_handlers = array(
      'servers' => 'servers',
      'server_arrays' => 'server_arrays'
    );

    parent::__construct($mixed);
  }

	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}

}