<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Model\Deployment;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerCommandsTest extends ClientCommandsBase {
	
	protected static $_cloud_name;
	protected static $_cloud_href;
	protected static $_depl_href;
	protected static $_server_href;
	protected static $testTs;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		$testClassToApproximateThis = new ServerCommandsTest();
		$testClassToApproximateThis->setUp();
				
		$command = null;
		$result = $testClassToApproximateThis->executeCommand1_5('clouds', array(), $command);
		$json_obj = json_decode($result->getBody(true));

		self::$_cloud_href = $json_obj[0]->links[0]->href;
		self::$_cloud_name = $json_obj[0]->name;
		
		// TODO: Eventually use the 1.5 deployment api to get the href
		$deplobj = new Deployment();
		$depl_list = $deplobj->index();
		foreach($depl_list as $depl) {
			if($depl->nickname == "Default") {
				self::$_depl_href = $testClassToApproximateThis->convertHrefFrom1to15($depl->href);
			}
		}
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand1_5('servers_create', array(
			'server[name]' => 'Guzzle_Test_' . self::$testTs,
			'server[deployment_href]' => self::$_depl_href,
			'server[instance][cloud_href]' => self::$_cloud_href,
			'server[instance][server_template_href]' => $testClassToApproximateThis->convertStHrefFrom1to15($testClassToApproximateThis->_serverTemplate->href)
		), $command);
		
		self::$_server_href = strval($command->getResponse()->getHeader('Location'));
	}
	
	public static function tearDownAfterClass() {
		$testClassToApproximateThis = new ServerCommandsTest();
		$testClassToApproximateThis->setUp();
				
		$command = null;
		$result = $testClassToApproximateThis->executeCommand1_5('servers_destroy', array('id' => $testClassToApproximateThis->getIdFromRelativeHref(self::$_server_href)), $command);
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanCreateServer() {		
		$command = null;
		$result = $this->executeCommand1_5('servers_create', array(
			'server[name]' => 'Guzzle_Test_' . $this->_testTs,
			'server[deployment_href]' => self::$_depl_href,
			'server[instance][cloud_href]' => self::$_cloud_href,
			'server[instance][server_template_href]' => $this->convertStHrefFrom1to15($this->_serverTemplate->href)			
		), $command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$id = $this->getIdFromRelativeHref($command->getResponse()->getHeader('Location'));
		
		return $id;
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 * @depends testCanCreateServer
	 */
	public function testCanDestroyServer($id) {
		$command = null;
		$result = $this->executeCommand1_5('servers_destroy', array('id' => $id), $command);
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanShowServerJson() {
		$command = null;
		$result = $this->executeCommand1_5('server', array('id' => $this->getIdFromRelativeHref(self::$_server_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $json_obj->name);
		$this->assertEquals(self::$_server_href, $json_obj->links[0]->href);		
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanShowServerXml() {
		$command = null;
		$result = $this->executeCommand1_5('server', array('id' => $this->getIdFromRelativeHref(self::$_server_href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $result->name);
		$this->assertEquals(self::$_server_href, $result->links->link[0]['href']);		
	}
	
}