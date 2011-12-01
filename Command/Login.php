<?php
// Copyright 2011 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

// http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Guzzle\Rs\Command;

use Guzzle\Service\Command\AbstractCommand;

/**
 * Logs into the RightScale API and stashes an authentication cookie
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 * 
 * @guzzle email doc="Your RightScale account email" required="true" type="string" 
 * @guzzle password doc="Your RightScale account password" required="true" type="string"
 *
 */
class Login extends AbstractCommand {
	
	protected function build() {
		$this->request = $this->client->get('/api/acct/{{acct_num}}/login');
		$this->request->setAuth($this->get('email'), $this->get('password'));
		$this->request->setHeader('X-API-VERSION', $this->client->getVersion());
	}

}

?>