<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ElasticIpCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_eip_href;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		$testClassToApproximateThis = new ElasticIpCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('ec2_elastic_ips_create',
			array(
				'ec2_elastic_ip[nickname]' => 'Guzzle_Test_' . self::$testTs
			),
			$command
		);
		
		self::$_eip_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new ElasticIpCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$eip_id = $testClassToApproximateThis->getIdFromHref('ec2_elastic_ips', self::$_eip_href);
		
		$testClassToApproximateThis->executeCommand('ec2_elastic_ips_destroy', array('id' => $eip_id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateElasticIp() {
		$command = null;
		$result = $this->executeCommand('ec2_elastic_ips_create',
			array(
				'ec2_elastic_ip[nickname]' => 'Guzzle_Test_' . $this->_testTs
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$ip_id = $this->getIdFromHref('ec2_elastic_ips', $command->getResponse()->getHeader('Location'));
		
		return $ip_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateElasticIp
	 */
	public function testCanDestroyElasticIp($ip_id) {
		$command = null;
		$result = $this->executeCommand('ec2_elastic_ips_destroy', array('id' => $ip_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListElasticIpsJson() {
		$command = null;
		$result = $this->executeCommand('ec2_elastic_ips', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListElasticIpsXml() {
		$propname = 'ec2-elastic-ip';
		$command = null;
		$result = $this->executeCommand('ec2_elastic_ips', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result->$propname));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowElasticIpJson() {
		$command = null;
		$result = $this->executeCommand('ec2_elastic_ip', array('id' => $this->getIdFromHref('ec2_elastic_ips', self::$_eip_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $json_obj->nickname);
		$this->assertEquals(self::$_eip_href, $json_obj->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowElasticIpXml() {		
		$command = null;
		$result = $this->executeCommand('ec2_elastic_ip', array('id' => $this->getIdFromHref('ec2_elastic_ips', self::$_eip_href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $result->nickname);
		$this->assertEquals(strval(self::$_eip_href), strval($result->href));
	}
	
}