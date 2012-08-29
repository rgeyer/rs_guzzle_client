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

namespace RGeyer\Guzzle\Rs\Model\Ec2;

use RGeyer\Guzzle\Rs\Model\ModelBase;
use InvalidArgumentException;

class Server extends ModelBase {
	
	public function __construct($mixed = null) {		
		$this->_path = 'server';
		$this->_required_params = array(
			'server[nickname]' => $this->castToString(),
			'server[ec2_ssh_key_href]' => $this->castToString(),
			'server[ec2_security_groups_href]' => null
		);
		$this->_optional_params = array(
			'server[aki_image_href]' 					=> $this->castToString(),
			'server[ari_image_href]' 					=> $this->castToString(),
			'server[ec2_image_href]' 					=> $this->castToString(),
			'server[vpc_subnet_href]' 				=> $this->castToString(),
			'server[ec2_user_data]' 					=> $this->castToString(),
			'server[server_template_href]' 		=> $this->castToString(),
			'server[ec2_elastic_ip_href]' 		=> $this->castToString(),
			'server[associate_eip_at_launch]' => $this->castToString(),
			'server[ec2_availability_zone]' 	=> $this->castToString(),
			'server[pricing]' 								=> $this->castToString(),
			'server[max_spot_price]' 					=> $this->castToFloat(),
			'server[deployment_href]' 				=> $this->castToString(),
			'server[instance_type]' 					=> $this->castToString(),
			'server[locked]'									=> $this->castToBool(),
			'cloud_id' 												=> $this->castToInt(),
			'parameters' 											=> null
		);
		$this->_base_params = array(
			'current_instance_href' => $this->castToString(),
			'@attributes' => null,
			'state' => $this->castToString(),
			'server_type' => $this->castToString()
		);
		
		parent::__construct($mixed);
	}
	
	/**
	 * Gets all defined alert specs for the server
	 * 
	 * TODO: Use the AlertSpec model
	 * 
	 * @return mixed An stdClass representing the alert_spec, or null if a parsing error occured
	 */
	public function alert_specs() {
		$result = $this->executeCommand($this->_path_for_regex . '_alert_specs', array('id' => $this->id));
		$json_str = $result->getBody(true);
		$json_obj = json_decode($json_str);
		return $json_obj;
	}
	
	/**
	 * Attaches an EBS volume to the instance
	 * 
	 * @param string $volume_href The HREF of an existing EBS volume which will be attached
	 * @param string $device The OS device the EBS volume will be attached to
	 */
	public function attach_volume($volume_href, $device) {
		$this->executeCommand($this->_path_for_regex . '_attach_volume',
			array('id' => $this->id, 'server[ec2_ebs_volume_href]' => $volume_href, 'server[device]' => $device)
		);		
	}
	
	/**
	 * Gets the settings for the current running server
	 * 
	 * @return mixed An stdClass representing the current settings, or null if a parsing error occurred
	 */
	public function current_settings() {
		$result = $this->executeCommand($this->_path_for_regex . '_current_settings', array('id' => $this->id));
		$json_str = $result->getBody(true);
		$json_obj = json_decode($json_str);
		return $json_obj;
	}
	
	/**
	 * Gets the current running server
	 * 
	 * @return Server The current running server.
	 */
	public function current_show() {
		$result = $this->executeCommand($this->_path_for_regex . '_current_show', array('id' => $this->id));
		return new Server($result);
	}
	
	/**
	 * Updates the current running servers input parameters
	 * 
	 * @param array $params An associative array where the key is the name of the input parameter to change, and the value is a value in the format <type>:<value>.  For instance text:foobar
	 * 
	 * @return boolean True if the update was successful (determined by the HTTP response), false otherwise
	 */
	public function current_update($params) {
		$result = $this->executeCommand($this->_path_for_regex . '_current_update', array('id' => $this->id, 'server[parameters]' => $params));
		return $result->getStatusCode() == 204;
	}

	/**
	 * Gets the raw monitoring data for the specified time period
	 * 
	 * @param integer $start The number of seconds in the past
	 * @param integer $end The number of seconds in the past
	 * @param string $variable The name of the collectd metric variable, example disk_ops
	 * @param string $resolution The RRA resolution, maybe an integer rather than a string
	 * @param string $plugin_name The name of the collectd plugin (e.g. mysql, cpu-0)
	 * @param string $plugin_type The type of the instance of the plugin (e.g. cpu-idle, cpu-wait, count)
	 * 
	 * @return mixed An stdClass representing the raw monitoring data, or null if a parsing error occurred
	 */
	public function get_sketch_data($start, $end, $variable=null, $resolution=null, $plugin_name=null, $plugin_type=null) {
		$params = array('id' => $this->id, 'start' => $start, 'end' => $end);
		if($variable) { $params['variable'] = $variable; }
		if($resolution) { $params['resolution'] = $resolution; }
		if($plugin_name) { $params['plugin_name'] = $plugin_name; }
		if($plugin_type) { $params['plugin_type'] = $plugin_type; }
		$result = $this->executeCommand($this->_path_for_regex . '_get_sketchy_data', $params);
		$json_str = $result->getBody(true);
		$json_obj = json_decode($json_str);
		return $json_obj;		
	}
	
	/**
	 * Gets the list of monitors for a server
	 * 
	 * @return mixed An stdClass representing the raw monitoring data, or null if a parsing error occurred
	 */
	public function monitoring() {
		$result = $this->executeCommand($this->_path_for_regex . '_monitoring', array('id' => $this->id));
		$json_str = $result->getBody(true);
		$json_obj = json_decode($json_str);
		return $json_obj;
	}
	
	/**
	 * Gets a URL for one specific monitoring graph
	 * 
	 * @param string $graph_name The name of the monitoring graph to fetch.
	 * @param string $size One of (tiny,small,large,xlarge)
	 * @param string $period One of (now,day,yday,week,lweek,month,quarter,year)
	 * @param string $tz The timezone to display on the graph
	 * @param string $title String that gets added to the graph title
	 * 
	 * @return string An href to the requested monitoring graph.
	 */
	public function monitoring_graph_name($graph_name, $size, $period, $tz, $title) {
		$result = $this->executeCommand($this->_path_for_regex . '_monitoring_graph_name',
			array('id' => $this->id, 'graph_name' => $graph_name, 'size' => $size, 'period' => $period, 'tz' => $tz, 'title' => $title)
		);
		$json_str = $result->getBody(true);
		$json_obj = json_decode($json_str);
		return $json_obj->href;
	}
	
	/**
	 * Reboots the running server
	 * 
	 * @return boolean True if the reboot request was sucessfully made, false otherwise
	 */
	public function reboot() {
		$result = $this->executeCommand($this->_path_for_regex . '_reboot', array('id' => $this->id));
		return $result->getStatusCode() == 200;
	}
	
	/**
	 * Runs a RightScript or Recipe on the server
	 * 
	 * Requires either a RightScript href or a Recipe name
	 * 
	 * @param string $right_script_href The href of the RightScript to run
	 * @param string $recipe The name of the recipe to run
	 * @param array $params An associative array where the key is the name of the input parameter to change, and the value is a value in the format <type>:<value>.  For instance text:foobar
	 * @param boolean $ignore_lock Allows server to ignore that it is locked if set to true
	 * 
	 * @throws \InvalidArgumentException If neither a RightScript or Recipe is specified
	 */
	public function run_executable($right_script_href=null, $recipe=null, $params=null, $ignore_lock=false) {
		if(!$right_script_href & !$recipe) {
			throw new InvalidArgumentException("Either right_script_href or recipe must be specified");
		}
		
		$parameters = array('id' => $this->id, 'server[ignore_lock]' => $ignore_lock);
		if($right_script_href) { $parameters['server[right_script_href]'] = $right_script_href; }
		if($recipe) { $parameters['server[recipe]'] = $recipe; }
		if($params) { $parameters['server[parameters]'] = $params; }
		$this->executeCommand($this->_path_for_regex . '_run_executable', $parameters);
	}
	
	/**
	 * Runs a RightScript on the server
	 * 
	 * @param string $right_script_href The href of the RightScript to run
	 * @param array $params An associative array where the key is the name of the input parameter to change, and the value is a value in the format <type>:<value>.  For instance text:foobar
	 * @param boolean $ignore_lock Allows server to ignore that it is locked if set to true
	 * 
	 */
	public function run_script($right_script_href=null, $params=null, $ignore_lock=false) {
		
		$parameters = array('id' => $this->id, 'server[ignore_lock]' => $ignore_lock, 'server[right_script_href]' => $right_script_href);
		if($params) { $parameters['server[parameters]'] = $params; }
		$this->executeCommand($this->_path_for_regex . '_run_script', $parameters);
	}
	
	/**
	 * Gets the settings for the server
	 * 
	 * @return mixed An stdClass representing the current settings, or null if a parsing error occurred
	 */
	public function settings() {
		$result = $this->executeCommand($this->_path_for_regex . '_settings', array('id' => $this->id));
		$json_str = $result->getBody(true);
		$json_obj = json_decode($json_str);
		return $json_obj;
	}
	
	/**
	 * Launches the server
	 * 
	 * @param array $params An associative array where the key is the name of the input parameter to change, and the value is a value in the format <type>:<value>.  For instance text:foobar
	 */
	public function start($params=null) {
		$parameters = array('id' => $this->id);		
		if($params) { $parameters['server[parameters]'] = $params; }
		$result = $this->executeCommand($this->_path_for_regex . '_start', $parameters);
	}
	
	/**
	 * Starts an EBS backed server that has been stopped
	 * 
	 * @param array $params An associative array where the key is the name of the input parameter to change, and the value is a value in the format <type>:<value>.  For instance text:foobar
	 */
	public function start_ebs($params=null) {
		$parameters = array('id' => $this->id);		
		if($params) { $parameters['server[parameters]'] = $params; }
		$result = $this->executeCommand($this->_path_for_regex . '_start_ebs', $parameters);
	}
	
	/**
	 * Terminates the server
	 * 
	 * @param boolean $ignore_lock Allows server to ignore that it is locked if set to true
	 */
	public function stop($ignore_lock=false) {
		$parameters = array('id' => $this->id, 'server[ignore_lock]');
		$result = $this->executeCommand($this->_path_for_regex . '_stop', $parameters);
	}
	
	/**
	 * Stops an EBS backed server
	 * 
	 * @param boolean $ignore_lock Allows server to ignore that it is locked if set to true
	 */
	public function stop_ebs($ignore_lock=false) {
		$parameters = array('id' => $this->id, 'server[ignore_lock]');
		$result = $this->executeCommand($this->_path_for_regex . '_stop_ebs', $parameters);
	}
}

?>