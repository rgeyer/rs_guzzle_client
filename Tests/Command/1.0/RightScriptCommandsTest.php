<?php
namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class RightScriptCommandsTest extends ClientCommandsBase {
	
	protected static $_script_id;
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListRightScriptsJson() {
		$command = null;
		$result = $this->executeCommand('right_scripts', array(), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));
		
		self::$_script_id = $this->getIdFromHref('right_scripts', $json_obj[0]->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListRightScriptsXml() {
		$command = null;
		$result = $this->executeCommand('right_scripts', array('output_format' => '.xml'), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$prop = 'right-script';
		$this->assertGreaterThan(0, count($result->$prop));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowRightScriptJson() {
		$command = null;
		$result = $this->executeCommand('right_script', array('id' => self::$_script_id), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowRightScriptXml() {
		$command = null;
		$result = $this->executeCommand('right_script', array('id' => self::$_script_id, 'output_format' => '.xml'), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertNotNull($result->href);
	}
}