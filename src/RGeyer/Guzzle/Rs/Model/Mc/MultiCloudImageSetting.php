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
 * A model for the RightScale MultiCloudImageSetting Resource in v1.5 of the API
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 */
class MultiCloudImageSetting extends ModelBase {
  
  public function __construct($mixed = null) {
    $this->_api_version = '1.5';
    
    $this->_path = 'multi_cloud_image_setting';
    $this->_optional_params = array(
      'multi_cloud_image_setting[cloud_href]' => $this->castToString(),
      'multi_cloud_image_setting[image_href]' => $this->castToString(),
      'multi_cloud_image_setting[instance_type_href]' => $this->castToString(),
      'multi_cloud_image_setting[kernel_image_href]' => $this->castToString(),
      'multi_cloud_image_setting[ramdisk_image_href]' => $this->castToString(),
      'multi_cloud_image_setting[user_data]' => $this->castToString()
    );
    
    parent::__construct($mixed);
  }

	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}
  
}