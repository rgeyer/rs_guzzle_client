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

use RGeyer\Guzzle\Rs\Model\AbstractSecurityGroup;
use BadMethodCallException;


/**
 * @property string $name The name of the security group
 * @property string $description The security group description
 * @property string $resource_uid A unique identifier within the cloud provider
 * 
 * @method RGeyer\Guzzle\Rs\Model\Mc\Cloud cloud() The cloud the SecurityGroup belongs to
 * @method RGeyer\Guzzle\Rs\Model\Mc\SecurityGroupeRule security_group_rules($params = null) A list of SecurityGroup rules
 */
class SecurityGroup extends AbstractSecurityGroup {

	public function __construct($mixed = null) {
		$this->_api_version = '1.5';
		
		$this->_path = 'security_group';
		$this->_required_params = array('security_group[name]' => $this->castToString(), 'cloud_id' => $this->castToInt());
		$this->_optional_params = array('security_group[description]' => $this->castToString());
		$this->_base_params = array(
				'resource_uid' => $this->castToString()
		);

    $this->_path_requires_cloud_id = true;
    $this->_id_is_alphanumeric = true;

    $this->_relationship_handlers = array(
      'cloud' => 'cloud',
      'security_group_rules' => 'security_group_rules'
    );

		parent::__construct($mixed);
	}

	public function update($params = null) {
		throw new BadMethodCallException($this->_path . " does not implement an update method");
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
   * @param int $from_port The starting port of a range of ports, or the ICMP type.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, the ICMP code or null.  If null is specified, this should default to the same as $from_port.
   * @return void
   */
  public function createCidrRule($protocol, $cidr_ips, $from_port, $to_port = null) {
    $params = array_merge($this->getCommonRuleParams($protocol, $from_port, $to_port),
      array(
        'security_group_rule[source_type]' => 'cidr_ips',
        'security_group_rule[cidr_ips]' => $cidr_ips
      )
    );

    $this->executeCommand('security_group_rules_create', $params);
  }

  /**
   * Creates an ingress rule for another security group to access this security group over the specified protocol and port(s)
   *
   * @throws \InvalidArgumentException If the protocol is ICMP, which is unsupported for group ingress rules
   * @param string $group_name The name of the ingress security group
   * @param string $group_owner The cloud user account name/number of the ingress security group
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param int $from_port The starting port of a range of ports, or the ICMP type.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, the ICMP code or null.  If null is specified, this should default to the same as $from_port.
   * @return void
   */
  public function createGroupRule($group_name, $group_owner, $protocol, $from_port, $to_port = null) {
    if($protocol == 'icmp') {
      throw new \InvalidArgumentException("ICMP is not supported for group ingress rules.  Please specify a CIDR based ingress rule for ICMP");
    }

    $params = array_merge($this->getCommonRuleParams($protocol, $from_port, $to_port),
      array(
        'security_group_rule[source_type]' => 'group',
        'security_group_rule[group_name]' => $group_name,
        'security_group_rule[group_owner]' => $group_owner
      )
    );

    $this->executeCommand('security_group_rules_create', $params);
  }

  /**
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param int $from_port The starting port of a range of ports, or the ICMP type.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, the ICMP code or null.  If null is specified, this should default to the same as $from_port.
   * @return array A parameters array to pass to ModelBase::executeCommand containing the common input params.  This should be merged with parameters specific and required for CIDR or group based rules.
   */
  private function getCommonRuleParams($protocol, $from_port, $to_port) {
    if($to_port == null) {
      $to_port = $from_port;
    }

    $to_port = strval($to_port);
    $from_port = strval($from_port);

    $params = array(
      'cloud_id' => $this->cloud_id,
      'security_group_id' => $this->id,
      'security_group_rule[protocol]' => $protocol
    );

    if($protocol == 'icmp') {
      $params = array_merge($params, array(
          'security_group_rule[protocol_details][icmp_code]' => $to_port,
          'security_group_rule[protocol_details][icmp_type]' => $from_port
        )
      );
    } else {
      $params = array_merge($params, array(
          'security_group_rule[protocol_details][end_port]' => $to_port,
          'security_group_rule[protocol_details][start_port]' => $from_port
        )
      );
    }

    return $params;
  }

}