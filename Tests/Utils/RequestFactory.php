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

namespace Guzzle\Rs\Tests\Utils;

class RequestFactory {
	
	public static function createServer($client, $params) {
		$permissible_keys = array('cloud_id', 'nickname', 'server_template_href', 'ec2_ssh_key_href',
			'ec2_security_groups_href', 'deployment_href', 'aki_image_href', 'ari_image_href', 'ec2_image_href',
			'vpc_subnet_href', 'instance_type', 'ec2_user_data', 'ec2_availability_zone', 'pricing', 'max_spot_price');
		
		if(array_diff($permissible_keys, array_keys($params))) {
			throw new InvalidArgumentException("An invalid parameter was supplied, only the following are permitted.\n" . print_r($permissible_keys, true));
		}
		
		$cmd = $client->getCommand('server_create', $params);
		$resp = $cmd->execute();
		$result = $cmd->getResult();

		return $result;
	}
	
	public static function createSshKey($client, $name, $cloud_id = null) {
		$param_ary = array('ec2_ssh_key[aws_key_name]' => $name);
		
		if($cloud_id) { $param_ary['cloud_id'] = $cloud_id; }
		
		$cmd = $client->getCommand('ec2_ssh_keys_create', $param_ary);
		$resp = $cmd->execute();		
		$result = $cmd->getResult();
		
		return $result;
	}
	
}

?>