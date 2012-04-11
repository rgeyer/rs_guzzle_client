<?php

namespace Guzzle\Rs\Test\Command;

use Guzzle\Rs\Model\ServerTemplate;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use Guzzle\Rs\Model\MultiCloudImage;

class ServerTemplateCommandsTest extends ClientCommandsBase {
	
	/**
	 * @var MultiCloudImage
	 */
	protected static $_mci;
	
	protected static $testTs;
	
	protected static $_st_href;

	public static function setUpBeforeClass() {
		self::$testTs = time();
		$mci = new MultiCloudImage();
		$list = $mci->index();

		self::$_mci = $list[0];
		$testClassToApproximateThis = new ServerTemplateCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('ec2_server_templates_create',
			array(
					'server_template[nickname]' => 'Guzzle_Test_' . self::$testTs,
					'server_template[description]' => 'described',
					'server_template[multi_cloud_image_href]' => self::$_mci->href
			),
			$command
		);
		
		self::$_st_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {
		$testClassToApproximateThis = new ServerTemplateCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$st_id = $testClassToApproximateThis->getIdFromHref('ec2_server_templates', self::$_st_href);
		$testClassToApproximateThis->executeCommand('ec2_server_templates_destroy', array('id' => $st_id));
	}

	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateServerTemplate() {
		$command = null;
		$result = $this->executeCommand('ec2_server_templates_create',
			array(
				'server_template[nickname]' => 'Guzzle_Test_' . $this->_testTs,
				'server_template[multi_cloud_image_href]' => self::$_mci->href
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$id = $this->getIdFromHref('ec2_server_templates', $command->getResponse()->getHeader('Location'));
		
		return $id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateServerTemplate
	 */
	public function testCanDestroyServerTemplate($id) {
		$command = null;
		$result = $this->executeCommand('ec2_server_templates_destroy', array('id' => $id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListServerTemplatesJson() {
		$command = null;
		$result = $this->executeCommand('ec2_server_templates', array(), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);		
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListServerTemplatesXml() {
		$command = null;
		$prop = 'ec2-server-template';
		$result = $this->executeCommand('ec2_server_templates', array('output_format' => '.xml'), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);		
		$this->assertGreaterThan(0, count($result->$prop));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowServerTemplateJson() {
		$command = null;
		$result = $this->executeCommand('ec2_server_template', array('id' => $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals($this->_serverTemplate->href, $json_obj->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowServerTemplateXml() {
		$command = null;
		$result = $this->executeCommand('ec2_server_template', array('id' => $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals($this->_serverTemplate->href, $result->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListExecutablesJson() {
		$command = null;
		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
		$result = $this->executeCommand('ec2_server_templates_executables', array('id' => $id, 'phase' => 'boot'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);		
		$this->assertGreaterThan(0, count($json_obj));
		$this->assertEquals('boot', $json_obj[0]->apply);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListExecutablesXml() {
		$command = null;
		$prop = 'server-template-executable';
		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
		$result = $this->executeCommand('ec2_server_templates_executables', array('id' => $id, 'phase' => 'boot', 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);		
		$this->assertGreaterThan(0, count($result));
		$result_prop = $result->$prop;
		$this->assertEquals('boot', $result_prop[0]->apply);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAlertSpecsJson() {
		$command = null;
		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
		$result = $this->executeCommand('ec2_server_templates_alert_specs', array('id' => $id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));				
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAlertSpecsXml() {
		$command = null;
		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
		$result = $this->executeCommand('ec2_server_templates_alert_specs', array('id' => $id, 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result));				
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateServerTemplate() {	
		$command = null;
		
		$st_id = $this->getIdFromHref('ec2_server_templates', self::$_st_href);				
		
		$result = $this->executeCommand('ec2_server_template', array('id' => $st_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('described too', $json_obj->description);
		
		$command = null;
		$result = $this->executeCommand('ec2_server_templates_update',
				array(
						'id' => $st_id,
						'server_template[description]' => 'described too'
				),
				&$command
		);
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('ec2_server_template', array('id' => $st_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('described too', $json_obj->description);
	}
}

?>