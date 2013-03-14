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

/**
 * @property array $elasticity_params
 * @property string $state
 * @property array $datacenter_policy
 * @property string $description
 * @property string $optimized
 * @property string $name
 * @property string $array_type
 * @property array $instance
 * @property int $instances_count
 *
 * @method RGeyer\Guzzle\Rs\Model\Mc\AlertSpec[] alert_specs() The alert specs for the array.
 * @method RGeyer\Guzzle\Rs\Model\Mc\Instance next_instance() The next instance to be launched into the array, the home of the "current" instance settings
 * @method RGeyer\Guzzle\Rs\Model\Mc\Instance[] current_instances() The current running instances
 */
class ServerArray extends ModelBase {

  public function __construct($mixed = null) {
    $this->_api_version = '1.5';
    
    $this->_path = 'server_array';
    $this->_required_params = array(
      'server_array[array_type]'                                  => $this->castToString(),
      'server_array[name]'                                        => $this->castToString(),
      'server_array[state]'                                       => $this->castToString(),
      'server_array[instance][cloud_href]'                        => $this->castToString(),
      'server_array[instance][server_template_href]'              => $this->castToString(),
      'server_array[elasticity_params][bounds][max_count]'        => $this->castToString(),
      'server_array[elasticity_params][bounds][min_count]'        => $this->castToString(),
      'server_array[elasticity_params][pacing][resize_calm_time]' => $this->castToString(),
      'server_array[elasticity_params][pacing][resize_down_by]'   => $this->castToString(),
      'server_array[elasticity_params][pacing][resize_up_by]'     => $this->castToString()
    );
    
    $this->_optional_params = array(
      'server_array[datacenter_policy]'
        => null,
      'server_array[deployment_href]'
        => $this->castToString(),
      'server_array[description]'
        => $this->castToString(),
      'server_array[elasticity_params][alert_specific_params][decision_threshold]'
        => $this->castToString(),
      'server_array[elasticity_params][alert_specific_params][voters_tag_predicate]'
        => $this->castToString(),
      'server_array[elasticity_params][queue_specific_params][collect_audit_entries]'
        => $this->castToString(),
      'server_array[elasticity_params][queue_specific_params][item_age][algorithm]'
        => $this->castToString(),
      'server_array[elasticity_params][queue_specific_params][item_age][max_age]'
        => $this->castToString(),
      'server_array[elasticity_params][queue_specific_params][item_age][regexp]'
        => $this->castToString(),
      'server_array[elasticity_params][queue_specific_params][queue_size][items_per_instance]'
        => $this->castToString(),
      'server_array[elasticity_params][schedule]'
        => null,
      'server_array[instance][datacenter_href]'
        => $this->castToString(),
      'server_array[instance][image_href]'
        => $this->castToString(),
      'server_array[instance][inputs]'
        => null,
      'server_array[instance][instance_type_href]'
        => $this->castToString(),
      'server_array[instance][kernel_image_href]'
        => $this->castToString(),
      'server_array[instance][multi_cloud_image_href]'
        => $this->castToString(),
      'server_array[instance][ramdisk_image_href]'
        => $this->castToString(),
      'server_array[instance][security_group_hrefs]'
        => null,
      'server_array[instance][ssh_key_href]'
        => $this->castToString(),
      'server_array[instance][userdata]'
        => $this->castToString()
    );
    $this->_base_params = array(
      'state' => $this->castToString(),
      'description' => $this->castToString(),
      'name' => $this->castToString(),
      'instances_count' => $this->castToInt(),
      'elasticity_params' => null
    );
    
    $this->_relationship_handlers = array(
      'alert_specs' => 'alert_specs',
      'next_instance' => 'instance',
      'current_instances' => 'instances'
    );
    
    parent::__construct($mixed);
  }

  /**
   * Run an executable on all instances of this array.  
   * 
   * @param string $recipe_name_or_right_script_href The name of a chef recipe, or the href of a rightscript to be executed
   * @param array $options An associative array (Hash) where valid keys are ['ignore_lock', 'inputs', 'filters'].  See http://reference.rightscale.com/api1.5/resources/ResourceInstances.html#multi_run_executable for details
   */
  public function multi_run_executable($recipe_name_or_right_script_href, array $options = array()) {
    $params = array('id' => $this->id);
    if (preg_match('/^\/api/', $recipe_name_or_right_script_href)) {
      $params['right_script_href'] = $recipe_name_or_right_script_href;
    } else {
      $params['recipe_name'] = $recipe_name_or_right_script_href;
    }
    if(count($options) > 0) {
      $params = array_merge($params, $options);
    }
    $this->executeCommand($this->_path_for_regex . '_multi_run_executable', $params);
  }
  
  /**
   * Terminate all instances, or those specified by the filter(s).
   * 
   * To terminate all, pass the option 'terminate_all' with a value of 'true'
   * 
   * @param array $options An associative array (Hash) where valid keys are ['terminate_all', 'filters'] See http://reference.rightscale.com/api1.5/resources/ResourceInstances.html#multi_terminate for details
   */
  public function multi_terminate(array $options = array()) {
    $params = array('id' => $this->id);
    if(count($options) > 0) {
      $params = array_merge($params, $options);
    }
    $this->executeCommand($this->_path_for_regex . '_multi_terminate', $params);
  }
  
  /**
   * Launches a new instance in the server array with the configuration defined in the 'next_instance'.
   * 
   * @param array $inputs An associative array (Hash) of inputs with the keys ['name', 'value'] 
   */
  public function launch(array $inputs = array()) {
    $params = array('id' => $this->id);
    if(count($inputs) > 0) {
      $params['inputs'] = $inputs;
    }
    $this->executeCommand($this->_path_for_regex . '_launch', $params);
  }
  
}