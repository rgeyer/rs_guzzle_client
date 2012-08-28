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

namespace RGeyer\Guzzle\Rs\Model;

use RGeyer\Guzzle\Rs\Model\ModelBase;

abstract class AbstractSecurityGroup extends ModelBase {

  /**
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param string $cidr_ips An IP range in CIDR notation. @see http://en.wikipedia.org/wiki/CIDR_notation
   * @param int $from_port The starting port of a range of ports.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, or null.  If null is specified, this should default to the same as $from_port.
   * @return void
   */
  public abstract function createCidrRule($protocol, $cidr_ips, $from_port, $to_port = null);

  /**
   * @param string $group_name The name of the ingress security group
   * @param string $group_owner The cloud user account name/number of the ingress security group
   * @param string $protocol Which protocol for the rule.  One of "tcp", "udp", or "icmp"
   * @param int $from_port The starting port of a range of ports.  If $to_port is null, this port will be used as the start and end of the range, effectively opening only this port number
   * @param mixed $to_port The ending port of a range of ports, or null.  If null is specified, this should default to the same as $from_port.
   * @return void
   */
  public abstract function createGroupRule($group_name, $group_owner, $protocol, $from_port, $to_port = null);

}