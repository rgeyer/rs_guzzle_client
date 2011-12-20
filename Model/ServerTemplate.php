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
 * A model for the RightScale ServerTemplate in v1.0 of the API
 * 
 * TODO Add MCI parsing
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 */
class ServerTemplate extends ModelBase {
	
	public function __construct($mixed = null) {
		$this->_path = 'server_template';
		$this->_required_params = array(
			'server_template[nickname]' => $this->castToString(),
			// TODO write a closure which checks for this, an MCI model, or a proper combination of other params. 
			'server_template[multi_cloud_image_href]' => $this->castToString()
		);
		
		$this->_optional_params = array(
			'server_template[description]' => $this->castToString()
		);
	}
	
	protected function intialize($mixed) {		
		
		parent::initialize($mixed);
	}
	
}

?>