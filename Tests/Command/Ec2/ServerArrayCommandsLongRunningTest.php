<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Model\Ec2\SshKey;

use RGeyer\Guzzle\Rs\Model\Ec2\Deployment;

use RGeyer\Guzzle\Rs\Model\Ec2\SecurityGroup;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerArrayCommandsLongRunningTest extends ClientCommandsBase {
	
	protected static $testTs;	
	protected static $_array_href;
	protected static $_ssh_key;
	protected static $_deployment;
	protected static $_security_group;
	protected static $_instance_href;
	
	public static function setUpBeforeClass() {		
		$testClassToApproximateThis = new ServerArrayCommandsLongRunningTest();
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
		
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('server_arrays_launch',array('id' => $testClassToApproximateThis->getIdFromHref('server_arrays', self::$_array_href)),$command);
		$instance_href = $command->getResponse()->getHeader('Location');
		
		self::$_instance_href = $instance_href;
		
		$testClassToApproximateThis->waitForInstanceState(array($instance_href), 'operational');
	}
	
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new ServerArrayCommandsLongRunningTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('server_arrays_terminate_all',array('id' => $testClassToApproximateThis->getIdFromHref('server_arrays', self::$_array_href)),$command);
		
		$testClassToApproximateThis->waitForInstanceState(array(self::$_instance_href), 'terminated_but_doesnt_matter');
		
		self::$_deployment->destroy();		
		self::$_ssh_key->destroy();		
		self::$_security_group->destroy();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('server_arrays_destroy',
			array('id' => $testClassToApproximateThis->getIdFromHref('server_arrays', self::$_array_href)),
			$command
		);
	}
	
	public function waitForInstanceState(array $instances, $state) {
		$found = 0;
		do {
			$found = 0;
			$command = null;
			$result = $this->executeCommand('server_arrays_instances',array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)),$command);
			$json_obj = json_decode($result->getBody(true));
			# No infinite waits if nothing is returned, likely when we're terminating.
			if(count($json_obj) == 0) return;
			foreach($json_obj as $instance) {
				if(in_array($instance->href, $instances) && $instance->state == $state) {
					$found++;
				}
			}
			sleep(10);
		} while ($found < count($instances));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanListInstancesJson() {
		$command = null;
		$result = $this->executeCommand('server_arrays_instances',array('id' => $this->getIdFromHref('server_arrays', self::$_array_href)),$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 * @depends testCanListInstancesJson
	 */
	public function testCanListInstancesXml() {
		$command = null;
		$result = $this->executeCommand('server_arrays_instances', array('id' => $this->getIdFromHref('server_arrays', self::$_array_href),'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @group long_running
	 */
	public function testCanRunScriptOnAllInstances() {
		$this->markTestIncomplete("Need to know a script id");
	}
}