<?php

namespace Guzzle\Rs\Test\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerTemplateCommandsTest extends ClientCommandsBase {

	public function testCanListAllServerTemplates() {
		$result = $this->executeCommand('server_templates');
		
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);		
		$this->assertGreaterThan(0, count($json_obj));
	}
	
}

?>