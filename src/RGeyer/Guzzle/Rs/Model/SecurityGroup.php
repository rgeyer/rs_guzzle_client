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

namespace RGeyer\Guzzle\Rs\Model;

use RGeyer\Guzzle\Rs\Model\ModelBase;
use BadMethodCallException;

class SecurityGroup extends AbstractSecurityGroup {
	
	public function __construct($mixed = null) {
		$this->_path = 'ec2_security_group';
		$this->_required_params = array(
      'ec2_security_group[aws_group_name]' => $this->castToString(),
      'ec2_security_group[aws_description]' => $this->castToString()
    );
		$this->_optional_params = array(
      'cloud_id' => $this->castToInt(),
      'ec2_security_group[protocol]' => $this->castToString(),
      'ec2_security_group[cidr_ips]' => $this->castToString(),
      'ec2_security_group[from_port]' => $this->castToInt(),
      'ec2_security_group[to_port]' => $this->castToInt()
    );
		$this->_base_params = array(
			// BUG aws_owner is only returned for json responses, not xml!
			'aws_owner' => $this->castToString(),			
			'aws_perms' => null
		);
		
		parent::__construct($mixed);
	}
	
	public function duplicate() {
		throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
	}

  /**
   * Creates a CIDR based security group rule.  Requires that security group already be created
   * or shown.
   *
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param string $cidr_ips An IP range in CIDR notation. @see http://en.wikipedia.org/wiki/CIDR_notation
   * @param int $from_port The starting port of a range of ports.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, or null.  If null is specified, this should default to the same as $from_port.
   * @return void
   */
  public function createCidrRule($protocol, $cidr_ips, $from_port, $to_port = null) {
    $params = array_merge($this->getCommonRuleParams($protocol, $from_port, $to_port),
      array(
        'ec2_security_group[cidr_ips]' => $cidr_ips
      )
    );

    $this->executeCommand('ec2_security_groups_update', $params);
  }

  /**
   * Creates an ingress rule for another security group to access this security group over the specified protocol and port(s)
   *
   * @param string $group_name The name of the ingress security group
   * @param string $group_owner The cloud user account name/number of the ingress security group
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param int $from_port The starting port of a range of ports, or the ICMP type.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, the ICMP code or null.  If null is specified, this should default to the same as $from_port.
   * @return void
   */
  public function createGroupRule($group_name, $group_owner, $protocol, $from_port, $to_port = null) {
    $params = array_merge($this->getCommonRuleParams($protocol, $from_port, $to_port),
      array(
        'ec2_security_group[owner]' => $group_owner,
        'ec2_security_group[group]' => $group_name
      )
    );

    $this->executeCommand('ec2_security_groups_update', $params);
  }

  /**
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param int $from_port The starting port of a range of ports.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, or null.  If null is specified, this should default to the same as $from_port.
   * @return array A parameters array to pass to ModelBase::executeCommand containing the common input params.  This should be merged with parameters specific and required for CIDR or group based rules.
   */
  private function getCommonRuleParams($protocol, $from_port, $to_port) {
    if($to_port == null) {
      $to_port = $from_port;
    }

    $params = array(
      'id' => $this->id,
      'ec2_security_group[protocol]' => $protocol,
      'ec2_security_group[from_port]' => $from_port,
      'ec2_security_group[to_port]' => $to_port
    );

    return $params;
  }
}

?>