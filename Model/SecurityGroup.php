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
use BadMethodCallException;

class SecurityGroup extends ModelBase
{
    public function __construct($mixed = null)
    {
        $this->_path = 'ec2_security_group';
        $this->_required_params = array('ec2_security_group[aws_group_name]' => $this->castToString(), 'ec2_security_group[aws_description]' => $this->castToString());
        $this->_optional_params = array('cloud_id' => $this->castToInt());
        $this->_base_params = array(
            // BUG aws_owner is only returned for json responses, not xml!
            'aws_owner' => $this->castToString(),
            'aws_perms' => null
        );

        parent::__construct($mixed);
    }

    public function duplicate()
    {
        throw new BadMethodCallException($this->_path . " does not implement a duplicate method");
    }
}