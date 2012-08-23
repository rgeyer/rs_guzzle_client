<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class AuditEntryCommandsTest extends ClientCommandsBase {
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowAuditEntryJson() {
		$command = null;
		$result = $this->executeCommand('audit_entry', array('id' => $_SERVER['AUDIT_ID']), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowAuditEntryXml() {
		$command = null;
		$result = $this->executeCommand('audit_entry', array('id' => $_SERVER['AUDIT_ID'], 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertNotNull($result);
	}
}