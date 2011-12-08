<?php

namespace Guzzle\Rs\Test\Command;

use Guzzle\Rs\Tests\Utils\RequestFactory;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerTemplateCommandsTest extends ClientCommandsBase {

	public function testCanListAllServerTemplates() {
		$cmd = $this->_client->getCommand('server_templates');
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);		
		$this->assertGreaterThan(0, count($json_obj));
	}
	
}

?>