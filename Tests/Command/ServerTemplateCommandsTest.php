<?php

namespace Guzzle\Rs\Test\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerTemplateCommandsTest extends ClientCommandsBase {	
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllServerTemplates() {
		$result = $this->executeCommand('ec2_server_templates');
		
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);		
		$this->assertGreaterThan(0, count($json_obj));
	}
	
}

?>