<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class CloudCommandsTest extends ClientCommandsBase {
	
	protected static $_cloud_name;
	protected static $_cloud_href;
	
	public static function setUpBeforeClass() {
		$testClassToApproximateThis = new CloudCommandsTest();
		$testClassToApproximateThis->setUp();
				
		$command = null;
		$result = $testClassToApproximateThis->executeCommand1_5('clouds', array(), $command);
		$json_obj = json_decode($result->getBody(true));
		
		self::$_cloud_href = $json_obj[0]->links[0]->href;
		self::$_cloud_name = $json_obj[0]->name;
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanListCloudsJson() {
		$command = null;
		$result = $this->executeCommand1_5('clouds', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));		
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanListCloudsXml() {
		$command = null;
		$result = $this->executeCommand1_5('clouds', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result));
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanListCloudsWithAFilter() {
		$command = null;				
		$result = $this->executeCommand1_5('clouds', array('filter' => array('name==' . self::$_cloud_name)), $command, 'with_filter');
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));
		$this->assertEquals(self::$_cloud_name, $json_obj[0]->name);
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanShowCloudJson() {
		$id = $this->getIdFromRelativeHref(self::$_cloud_href);
		$command = null;
		$result = $this->executeCommand1_5('cloud', array('id' => $id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals(self::$_cloud_name, $json_obj->name);
		$this->assertEquals(self::$_cloud_href, $json_obj->links[0]->href);
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanShowCloudXml() {
		$id = $this->getIdFromRelativeHref(self::$_cloud_href);
		$command = null;
		$result = $this->executeCommand1_5('cloud', array('id' => $id, 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);		
		$this->assertEquals(self::$_cloud_name, $result->name);
		$this->assertEquals(self::$_cloud_href, $result->links->link[0]['href']);
	}
}