<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SecurityGroupCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_secgrp_href;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		$testClassToApproximateThis = new SecurityGroupCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand1_5('security_groups_create',
				array(
						'security_group[name]' => 'Guzzle_Test_' . self::$testTs,
						'cloud_id' => $_SERVER['SECGRP_CLOUD_ID']
				),
				$command
		);
		
		self::$_secgrp_href = strval($command->getResponse()->getHeader('Location'));
	}
	
	public static function tearDownAfterClass() {
		$testClassToApproximateThis = new SecurityGroupCommandsTest();
		$testClassToApproximateThis->setUp();

		$id = $testClassToApproximateThis->getIdFromRelativeHref(self::$_secgrp_href);
		
		$testClassToApproximateThis->executeCommand1_5('security_groups_destroy', array('id' => $id, 'cloud_id' => $_SERVER['SECGRP_CLOUD_ID']));
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanCreateSecurityGroup() {
		$command = null;
		$result = $this->executeCommand1_5('security_groups_create',
			array(
				'security_group[name]' => 'Guzzle_Test_' . $this->_testTs,
				'cloud_id' => $_SERVER['SECGRP_CLOUD_ID']
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));		
		
		$id = $this->getIdFromRelativeHref($command->getResponse()->getHeader('Location'));
		
		return $id;		
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 * @depends testCanCreateSecurityGroup
	 */
	public function testCanDestroySecurityGroup($id) {
		$command = null;
		$result = $this->executeCommand1_5('security_groups_destroy', array('id' => $id, 'cloud_id' => $_SERVER['SECGRP_CLOUD_ID']), $command);
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
	}
	
	/**
	 * @group v1_5
	 * @group integration 
	 */
	public function testCanListSecurityGroupsJson() {
		$command = null;
		$result = $this->executeCommand1_5('security_groups', array('cloud_id' => $_SERVER['SECGRP_CLOUD_ID']), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));		
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 * 
	 * TODO: Not testing filters or views
	 */
	public function testCanListSecurityGroupsXml() {
		$command = null;
		$result = $this->executeCommand1_5('security_groups', array('cloud_id' => $_SERVER['SECGRP_CLOUD_ID'], 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result));		
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanShowSecurityGroupJson() {
		$command = null;
		$result = $this->executeCommand1_5('security_group', array('id' => $this->getIdFromRelativeHref(self::$_secgrp_href), 'cloud_id' => $_SERVER['SECGRP_CLOUD_ID']), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $json_obj->name);
	}
	
	/**
	 * @group v1_5
	 * @group integration
	 */
	public function testCanShowSecurityGroupXml() {
		$command = null;
		$result = $this->executeCommand1_5('security_group', array('id' => $this->getIdFromRelativeHref(self::$_secgrp_href), 'cloud_id' => $_SERVER['SECGRP_CLOUD_ID'], 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $result->name);		
	}
	
}