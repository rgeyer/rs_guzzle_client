<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class MacroCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_macro_href;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		$testClassToApproximateThis = new MacroCommandsTest();
		$testClassToApproximateThis->setUp();

		$command = null;
		$result = $testClassToApproximateThis->executeCommand('macros_create',
			array(
				'macro[source_type]' => 'blank',
				'macro[commands]' => 'alert("foo");'
			),
			$command
		);
		
		self::$_macro_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {
		$testClassToApproximateThis = new MacroCommandsTest();
		$testClassToApproximateThis->setUp();

		$macro_id = $testClassToApproximateThis->getIdFromHref('macros', self::$_macro_href);
		
		$testClassToApproximateThis->executeCommand('macros_destroy', array('id' => $macro_id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * 
	 * TODO: Haven't really tested creating from the other source types (deployment, array, server, macro)
	 */
	public function testCanCreateMacro() {
		$command = null;
		$result = $this->executeCommand('macros_create',
			array(
				'macro[source_type]' => 'blank',
				'macro[commands]' => 'alert("foo");'
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$regex = ',https://.+/api/acct/[0-9]+/macros/([0-9]+),';
		$matches = array();
		preg_match($regex, $command->getResponse()->getHeader('Location'), $matches);
		
		$macro_id = $this->getIdFromHref('macros', $command->getResponse()->getHeader('Location'));
		
		return $macro_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateMacro
	 */
	public function testCanDestroyMacro($macro_id) {
		$command = null;
		$result = $this->executeCommand('macros_destroy', array('id' => $macro_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListMacrosJson() {
		$command = null;
		$result = $this->executeCommand('macros', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));	
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListMacrosXml() {
		$command = null;
		$result = $this->executeCommand('macros', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result->macro));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowMacroJson() {
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('alert("foo");', $json_obj->commands);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowMacroXml() {
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('alert("foo");', $result->commands);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateMacroName() {
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('NameChanged', $json_obj->nickname);
		
		$command = null;
		$result = $this->executeCommand('macros_update',
			array(
				'id' => $this->getIdFromHref('macros', self::$_macro_href),
				'macro[nickname]' => 'NameChanged'
			),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
		
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('NameChanged', $json_obj->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateMacroDescription() {
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('DescChanged', $json_obj->description);
		
		$command = null;
		$result = $this->executeCommand('macros_update',
			array(
				'id' => $this->getIdFromHref('macros', self::$_macro_href),
				'macro[description]' => 'DescChanged'
			),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
		
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('DescChanged', $json_obj->description);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateMacroCommands() {
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('alert("bar");', $json_obj->commands);
		
		$command = null;
		$result = $this->executeCommand('macros_update',
			array(
				'id' => $this->getIdFromHref('macros', self::$_macro_href),
				'macro[commands]' => 'alert("bar");'
			),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
		
		$command = null;
		$result = $this->executeCommand('macro', array('id' => $this->getIdFromHref('macros', self::$_macro_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('alert("bar");', $json_obj->commands);
	}
}