<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Model\SshKey;

use RGeyer\Guzzle\Rs\Model\Deployment;

use RGeyer\Guzzle\Rs\Model\SecurityGroup;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerArrayCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;	
	protected static $_array_href;
	protected static $_ssh_key;
	protected static $_deployment;
	protected static $_security_group;
	
	public static function setUpBeforeClass() {		
		$testClassToApproximateThis = new ServerArrayCommandsTest();
		$testClassToApproximateThis->setUp();
		
		self::$testTs = time();		
		self::$_ssh_key = new SshKey(); 
		self::$_ssh_key->aws_key_name = "Guzzle_Test_For_Server_Arrays_" . self::$testTs;
		self::$_ssh_key->create();
		
		self::$_deployment = new Deployment();
		self::$_deployment->nickname = "Guzzle_Test_For_Server_Arrays_". self::$testTs;
		self::$_deployment->description = 'described';
		self::$_deployment->create();
		
		self::$_security_group = new SecurityGroup();
		self::$_security_group->aws_group_name = "Guzzle_Test_For_Server_Arrays_". self::$testTs;
		self::$_security_group->aws_description = "described";
		self::$_security_group->create();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('server_arrays_create',
			array(
				'server_array[nickname]' => 'Guzzle_Test_' . self::$testTs,
				'server_array[deployment_href]' => self::$_deployment->href,
				'server_array[array_type]' => 'alert',
				'server_array[ec2_security_groups_href]' => array(self::$_security_group->href),
				'server_array[server_template_href]' => $testClassToApproximateThis->_serverTemplate->href,
				'server_array[ec2_ssh_key_href]' => self::$_ssh_key->href,
				'server_array[voters_tag]' => 'foo:bar=baz'
			),
			$command
		);
		
		self::$_array_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new ServerArrayCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('server_arrays_destroy',
				array('id' => $testClassToApproximateThis->getIdFromHref('server_arrays', self::$_array_href)),
				$command
		);
		
		self::$_deployment->destroy();		
		self::$_ssh_key->destroy();
		# The security group doesn't like being destroyed so shortly after things which consume it.
		sleep(2);		
		self::$_security_group->destroy();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateServerArray() {
		$command = null;
		$result = $this->executeCommand('server_arrays_create',
			array(
				'server_array[nickname]' => 'Guzzle_Test_' . $this->_testTs,
				'server_array[deployment_href]' => self::$_deployment->href,
				'server_array[array_type]' => 'alert',
				'server_array[ec2_security_groups_href]' => array(self::$_security_group->href),
				'server_array[server_template_href]' => $this->_serverTemplate->href,
				'server_array[ec2_ssh_key_href]' => self::$_ssh_key->href,
				'server_array[voters_tag]' => 'foo:bar=baz',
				'server_array[ec2_availability_zone]' => 'us-east-1a'
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$array_id = $this->getIdFromHref('server_arrays', $command->getResponse()->getHeader('Location'));
		
		return $array_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateServerArray
	 */
	public function testCanDestroyServerArray($array_id) {
		$command = null;
		$result = $this->executeCommand('server_arrays_destroy', array('id' => $array_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListServerArraysJson() {
		$command = null;
		$result = $this->executeCommand('server_arrays', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListServerArraysXml() {
		$propname = 'server-array';
		$command = null;
		$result = $this->executeCommand('server_arrays', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result->$propname));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowServerArrayJson() {
		$command = null;
		$result = $this->executeCommand('server_array', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $json_obj->nickname);
		$this->assertEquals(self::$_array_href, $json_obj->href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowServerArrayXml() {
		$command = null;
		$result = $this->executeCommand('server_array', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('Guzzle_Test_' . self::$testTs, $result->nickname);
		$this->assertEquals(strval(self::$_array_href), strval($result->href));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateServerArrayNickname() {
		$this->markTestSkipped("Setting nickname results in a 422?");
		$command = null;
		$result = $this->executeCommand('server_array', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertNotEquals('NewNickname', $json_obj->nickname);
		
		$command = null;
		$result = $this->executeCommand('server_arrays_update',
			array(
				'id' => $this->getIdFromHref('server_arrays', self::$_array_href),
				'server_array[nickname]' => 'NewNickname'),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('server_array', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('NewNickname', $json_obj->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateServerArrayDescription() {
		$this->markTestSkipped("Setting description results in a 422?");
		$command = null;
		$result = $this->executeCommand('server_array', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertNotEquals('NewDescription', $json_obj->description);
		
		$command = null;
		$result = $this->executeCommand('server_arrays_update',
			array(
				'id' => $this->getIdFromHref('server_arrays', self::$_array_href),
				'server_array[description]' => 'NewDescription'),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('server_array', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('NewDescription', $json_obj->description);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanLaunchAServer() {
		$command = null;
		$result = $this->executeCommand('server_arrays_launch',array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)),$command);
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$instance_href = $command->getResponse()->getHeader('Location');
		$this->assertNotNull($instance_href);
		return strval($instance_href);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanLaunchAServer
	 */
	public function testCanTerminateAllServers($instance_href) {
		$propname = 'ec2-instance-href';
		$command = null;
		$result = $this->executeCommand('server_arrays_terminate_all',array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)),$command);
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectHasAttribute('success', $result);
		$this->assertObjectHasAttribute('failure', $result);
		$this->assertEquals(1, count($result->success));
		$this->assertEquals($instance_href, $result->success[0]->$propname);
	}
}