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
 * A model for the RightScale SecurityGroupRule Resource in v1.5 of the API
 * @see http://reference.rightscale.com/api1.5/media_types/MediaTypeSecurityGroupRule.html 
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * 
 * @property string $icmp_type
 * @property string $group_name
 * @property string $icmp_code
 * @property string $protocol
 * @property string $group_owner
 * @property string $cidr_ips
 * @property string $start_port
 * @property string $end_port
 * 
 * @method RGeyer\Guzzle\Rs\Model\SecurityGroup security_group() The SecurityGroup this SecurityGroupRule belongs to
 *
 */
class SecurityGroupRule extends ModelBase {

	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'security_group_rule';
		$this->_required_params = array(
	    'security_group_rule[protocol]' => $this->castToString(),
	    'security_group_rule[source_type]' => $this->castToString()
    );
		$this->_optional_params = array(
	    'security_group_rule[cidr_ips]' => $this->castToString(),
	    'security_group_rule[group_name]' => $this->castToString(),
	    'security_group_rule[group_owner]' => $this->castToString(),
	    'security_group_rule[protocol_details][end_port]' => $this->castToString(),
	    'security_group_rule[protocol_details][icmp_code]' => $this->castToString(),
	    'security_group_rule[protocol_details][icmp_type]' => $this->castToString(),
	    'security_group_rule[protocol_details][start_port]' => $this->castToString(),
	    'security_group_rule[security_group_href]' => $this->castToString()		    
    );

    $this->_relationship_handlers = array(
      'security_group' => 'security_group'
    );

		parent::__construct($mixed);
	}

	public function update($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement an update method");
	}

	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}
	
}