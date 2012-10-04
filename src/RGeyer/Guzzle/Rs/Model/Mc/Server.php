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

use RGeyer\Guzzle\Rs\Model\AbstractServer;
use BadMethodCallException;

class Server extends AbstractServer {
	
	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'server';
		$this->_required_params = array(
			'server[name]' 														=> $this->castToString(),
			'server[deployment_href]' 			          => $this->castToString(),
			'server[instance][cloud_href]'						=> $this->castToString(),
			'server[instance][server_template_href]' 	=> $this->castToString()
		);
		$this->_optional_params = array(
			'server[description]' 											=> $this->castToString(),
			'server[instance][datacenter_href]' 				=> $this->castToString(),
			'server[instance][image_href]' 							=> $this->castToString(),
			'server[instance][inputs]' 									=> null,
			'server[instance][instance_type_href]' 			=> $this->castToString(),
			'server[instance][kernel_image_href]' 			=> $this->castToString(),
			'server[instance][multi_cloud_image_href]' 	=> $this->castToString(),
			'server[instance][ramdisk_image_href]' 			=> $this->castToString(),
			'server[instance][security_group_hrefs]' 		=> null,
			'server[instance][ssh_key_href]' 						=> $this->castToString(),
			'server[instance][user_data]' 							=> $this->castToString()
		);
		$this->_base_params = array(
			'state' => $this->castToString()
		);
		
		parent::__construct($mixed);
	}

  /**
   * {@inheritdoc}
   */
	public function launch($inputs=null) {
		$parameters = array('id' => $this->id);
		if($inputs) { $parameters['inputs'] = $inputs; }
		$result = $this->executeCommand($this->_path_for_regex . '_launch', $parameters);
	}

  /**
   * {@inheritdoc}
   */
  public function terminate() {
    $parameters = array('id' => strval($this->id));
    $result = $this->executeCommand($this->_path_for_regex . '_terminate', $parameters);
  }

  /**
   * {@inheritdoc}
   */
  public function addTags(array $tags) {
    $this->executeCommand('tags_multi_add',
      array(
        'resource_hrefs' => array($this->href),
        'tags' => $tags
      )
    );
  }

  /**
   * {@inheritdoc}
   */
  public function deleteTags(array $tags) {
    $this->executeCommand('tags_multi_delete',
      array(
        'resource_hrefs' => array($this->href),
        'tags' => $tags
      )
    );
  }

  /**
   * TODO: Refactor this to return a model.
   * Even better, add magic methods to ModelBase which accesses the resources
   * at the end of all links
   *
   * @return stdClass|null A stdClass representing the properties of an Instance Resource or null if there is no current instance
   */
  public function current_instance() {
    $retval = null;
    $instance_href = null;
    foreach($this->links as $link) {
      if($link->rel == 'current_instance') {
        $instance_href = $link->href;
      }
    }
    if($instance_href) {
      $instance_href = str_replace('/api/', '', $instance_href);
      $command = $this->_client->getCommand('instance', array('path' => $instance_href, 'id' => 'foo', 'cloud_id' => '123'));
      $command->execute();
      $result = $command->getResult();
      $retval = json_decode($result->getBody(true));
    }
    return $retval;
  }
}
