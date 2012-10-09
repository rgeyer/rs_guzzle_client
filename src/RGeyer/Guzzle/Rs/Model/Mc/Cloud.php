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
use \BadMethodCallException;

/**
 * A model for the RightScale Cloud Resource in v1.5 of the API
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * @property string $name
 * @property string $description
 * @property string $cloud_type
 */
class Cloud extends ModelBase {
	
	/**
	 * Creates a new Cloud object.
	 * 
	 * @param mixed $mixed
	 */
	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'cloud';
		$this->_base_params = array(
      'name' => $this->castToString(),
      'description' => $this->castToString(),
      'cloud_type' => $this->castToString()
    );
		
		parent::__construct($mixed);
	}
	
	/**
	 * Returns all clouds in a hash where the hash key is the ID of the cloud
	 * 
	 * I.E.
	 * 
Array
(
    [11111] => stdClass Object
        (
            [links] => Array
                (
                    [0] => stdClass Object
                        (
                            [rel] => self
                            [href] => /api/clouds/11111
                        )

                    [1] => stdClass Object
                        (
                            [rel] => datacenters
                            [href] => /api/clouds/11111/datacenters
                        )

                    [2] => stdClass Object
                        (
                            [rel] => instance_types
                            [href] => /api/clouds/11111/instance_types
                        )

                    [3] => stdClass Object
                        (
                            [rel] => security_groups
                            [href] => /api/clouds/11111/security_groups
                        )

                    [4] => stdClass Object
                        (
                            [rel] => instances
                            [href] => /api/clouds/11111/instances
                        )

                    [5] => stdClass Object
                        (
                            [rel] => images
                            [href] => /api/clouds/11111/images
                        )

                    [6] => stdClass Object
                        (
                            [rel] => volume_attachments
                            [href] => /api/clouds/11111/volume_attachments
                        )

                    [7] => stdClass Object
                        (
                            [rel] => volume_snapshots
                            [href] => /api/clouds/11111/volume_snapshots
                        )

                    [8] => stdClass Object
                        (
                            [rel] => volume_types
                            [href] => /api/clouds/11111/volume_types
                        )

                    [9] => stdClass Object
                        (
                            [rel] => volumes
                            [href] => /api/clouds/11111/volumes
                        )

                )

            [description] => Cloud.com Private Cloud
            [name] => MyCloud - Cloud.com
            [href] => /api/clouds/11111
            [id] => 11111
        )

    [22222] => stdClass Object
        (
            [links] => Array
                (
                    [0] => stdClass Object
                        (
                            [rel] => self
                            [href] => /api/clouds/22222
                        )

                    [1] => stdClass Object
                        (
                            [rel] => datacenters
                            [href] => /api/clouds/22222/datacenters
                        )

                    [2] => stdClass Object
                        (
                            [rel] => instance_types
                            [href] => /api/clouds/22222/instance_types
                        )

                    [3] => stdClass Object
                        (
                            [rel] => security_groups
                            [href] => /api/clouds/22222/security_groups
                        )

                    [4] => stdClass Object
                        (
                            [rel] => instances
                            [href] => /api/clouds/22222/instances
                        )

                    [5] => stdClass Object
                        (
                            [rel] => images
                            [href] => /api/clouds/22222/images
                        )

                    [6] => stdClass Object
                        (
                            [rel] => volume_attachments
                            [href] => /api/clouds/22222/volume_attachments
                        )

                    [7] => stdClass Object
                        (
                            [rel] => volume_snapshots
                            [href] => /api/clouds/22222/volume_snapshots
                        )

                    [8] => stdClass Object
                        (
                            [rel] => volume_types
                            [href] => /api/clouds/22222/volume_types
                        )

                    [9] => stdClass Object
                        (
                            [rel] => volumes
                            [href] => /api/clouds/22222/volumes
                        )

                )

            [description] => New York Metro
            [name] => Datapipe New York Metro
            [href] => /api/clouds/22222
            [id] => 22222
        )
   )
	 *
	 * @return array
	 */
	public function indexAsHash() {
		$clouds = $this->index();
		$hash = array();
		foreach($clouds as $cloud) {
			$hash[$cloud->id] = $cloud;
		}
		return $hash;
	}
	
	/**
	 * Indicates whether the cloud supports security groups, determined by the presence or absence of a 
	 * security group href in the 'links' list for the cloud.
	 * 
	 * @return boolean A boolean indicating if this cloud supports security groups
	 */
	public function supportsSecurityGroups() {
		$retval = false;
		foreach($this->links as $link) {
			if($link->rel == 'security_groups') {
				$retval = true;
				break;
			}
		}
		return $retval;
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