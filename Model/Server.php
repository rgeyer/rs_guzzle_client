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

use Guzzle\Rs\Model\ModelBase;

class Server extends ModelBase {
	
	public function __construct($mixed = null) {
		$this->_path = 'server';
		$this->_required_params = array(
			'server[nickname]' => null,
			'server[ec2_ssh_key_href]' => null,
			'server[ec2_security_groups_href]' => function($value, $params) { return $value; }
		);
		$this->_optional_params = array('server[server_template_href]' => null, 'server[deployment_href]' => null);
		
		parent::__construct($mixed);
	}

}

?>