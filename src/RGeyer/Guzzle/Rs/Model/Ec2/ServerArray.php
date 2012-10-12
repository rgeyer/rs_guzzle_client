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

namespace RGeyer\Guzzle\Rs\Model\Ec2;

use RGeyer\Guzzle\Rs\Model\ModelBase;

/**
 * A model for the RightScale Server Array in v1.0 of the API
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 */
class ServerArray extends ModelBase {
	
	public function __construct($mixed = null) {
		$this->_path = 'server_array';
		$this->_required_params = array(
			'server_array[nickname]' 									=> $this->castToString(),
			'server_array[deployment_href]' 					=> $this->castToString(),
			'server_array[array_type]' 								=> $this->castToString(),
			'server_array[ec2_security_groups_href]' 	=> null,
			'server_array[server_template_href]' 			=> $this->castToString(),
			'server_array[ec2_ssh_key_href]' 					=> $this->castToString()
		);
		$this->_optional_params = array(
			'cloud_id' 																						=> $this->castToInt(),
			'server_array[ec2_availability_zone]'									=> $this->castToString(),
			'server_array[description]' 													=> $this->castToString(),
			'server_array[indicator_href]' 												=> $this->castToString(),
			'server_array[audit_queue_href]' 											=> $this->castToString(),
			'server_array[collect_audit_entries]' 								=> $this->castToInt(),
			'server_array[voters_tag]' 														=> $this->castToString(),
			'server_array[elasticity]' 														=> null,
			/*
			'server_array[elasticity][max_count]' 								=> $this->castToInt(),
			'server_array[elasticity][min_count]' 								=> $this->castToInt(),
			'server_array[elasticity][resize_up_by]' 							=> $this->castToInt(),
			'server_array[elasticity][resize_down_by]' 						=> $this->castToInt(),
			'server_array[elasticity][resize_calm_time]' 					=> $this->castToInt(),
			'server_array[elasticity][decision_threshold]' 				=> $this->castToInt(),*/
			'server_array[elasticity_function]' 									=> $this->castToString(),
			'server_array[elasticity_params]'											=> null,
			/*
			'server_array[elasticity_params][items_per_instance]' => $this->castToInt(),
			'server_array[elasticity_params][max_age]' 						=> $this->castToInt(),
			'server_array[elasticity_params][algorithm]' 					=> $this->castToString(),
			'server_array[elasticity_params][regexp]' 						=> $this->castToString(),*/
			'server_array[active]' 																=> $this->castToBool(),
			'server_array[parameters]' 														=> null				
		);
		$this->_base_params = array(
			'elasticity_stat' => null,
			'active_instances_count' => $this->castToInt(),
			'total_instances_count' => $this->castToInt()
		);
		
		parent::__construct($mixed);
	}
	
	/**
	 * Lists all instances in the array
	 * 
	 * @see http://support.rightscale.com/rdoc/ApiR1V0/Docs/ApiEc2ServerArrays.html#instances
	 * 
	 * @return An array of hashes representing instances
	 */
	public function instances() {
		$result = $this->executeCommand($this->_path_for_regex . '_instances', array('id' => $this->id));
		return $result;
	}
	
	/**
	 * Launches a new server instance in the array
	 * 
	 * @see http://support.rightscale.com/rdoc/ApiR1V0/Docs/ApiEc2ServerArrays.html#launch
	 * 
	 * @return Guzzle\Http\Message\Response The guzzle response
	 */
	public function launch() {
		$result = $this->executeCommand($this->_path_for_regex . '_launch', array('id' => $this->id));
		return $result;
	}
	
	/**
	 * Executes a script on all running instances in the array
	 * 
	 * @see http://support.rightscale.com/rdoc/ApiR1V0/Docs/ApiEc2ServerArrays.html#run_script_on_all
	 * 
	 * @param string $script_href The href of a RightScript
	 * @param array $params An array of parameters with which to execute the script
	 * 
	 * @return Guzzle\Http\Message\Response The guzzle response
	 */
	public function run_script_on_all($script_href, array $params) {
		return $this->executeCommand($this->_path_for_regex . '_run_script_on_all',
			array('id' => $this->id, 'server_array[parameters]' => $params)
		);
	}
	
	/**
	 * Terminates all instances in the array
	 * 
	 * TODO: Sanitize the output, apparently when only a single instance succeeds or fails, the response is
	 * a string.  If many are successful it is (probably) an array.  Also, the status which contains
	 * no HREF's still has a single empty array index.
	 * 
	 * @see http://support.rightscale.com/rdoc/ApiR1V0/Docs/ApiEc2ServerArrays.html#terminate_all
	 * 
	 * @return SimpleXMLElement The response XML object
	 */
	public function terminate_all() {
		return $this->executeCommand($this->_path_for_regex . '_terminate_all', array('id' => $this->id));
	}
	
}