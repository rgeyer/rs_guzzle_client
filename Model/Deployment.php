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

use Guzzle\Http\Message\Response;

use Guzzle\Rs\Model\ModelBase;
use Guzzle\Rs\Common\ClientFactory;

/**
 * A model for the RightScale Deployment in v1.0 of the API
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 */
class Deployment extends ModelBase {
	
	/**
	 * Creates a new Deployment object.
	 * 
	 * @param mixed $mixed
	 */
	public function __construct($mixed = null) {
		$this->_path = 'deployment';
		$this->_required_params = array('deployment[nickname]' => $this->castToString());
		$this->_optional_params = array('deployment[description]' => $this->castToString(), 'deployment[default_vpc_subnet_href]' => $this->castToString(), 'deployment[default_ec2_availability_zone]' => $this->castToString());
		$this->_base_params = array('servers' => $this->parseServers());
		
		parent::__construct($mixed);
	}
	
	protected function initialize($mixed) {
		
		parent::initialize($mixed);
	}
	
	protected function parseServers() {
		return function($value, $params) {
			$servers = array();
			foreach($value as $server) {
				$servers[] = new Server($server);
			}
			return $servers;
		};
	}
	
	/**
	 * @return Response
	 */
	public function update() {
		$params = array(
				'id' => $this->id,
				'deployment[nickname]' => $this->nickname,
				'deployment[description]' => $this->description,
				'deployment[default_vpc_subnet_href]' => $this->default_vpc_subnet_href,
				'deployment[default_ec2_availability_zone]' => $this->default_ec2_availability_zone
				);
		$result = $this->executeCommand('deployments_update', $params);
		return $result;
	}
	
	/**
	 * @return Response
	 */
	public function start_all() {
		return $this->executeCommand($this->_path_for_regex . '_start_all', array('id' => $this->id));
	}
	
	/**
	 * @return Response
	 */
	public function stop_all() {
		return $this->executeCommand($this->_path_for_regex . '_stop_all', array('id' => $this->id));
	}

}

?>