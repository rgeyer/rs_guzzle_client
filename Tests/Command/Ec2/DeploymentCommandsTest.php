<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Model\Ec2\Deployment;

class DeploymentCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_deployment;	
	
	/**
	 * Prepares the environment before running a test.
	 */
	public static function setUpBeforeClass() {		
		self::$testTs = time();
		self::$_deployment = new Deployment();
		self::$_deployment->nickname = "Guzzle_Test_". self::$testTs;
		self::$_deployment->description = "This'll stick around for a bit";  		
		self::$_deployment->create();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new DeploymentCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$result = $testClassToApproximateThis->executeCommand('deployments_destroy', array('id' => self::$_deployment->id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateOneDeployment() {
		$command = null;		
		$result = $this->executeCommand('deployments_create', array(
			'deployment[nickname]' => "Guzzle Integration Test_" . $this->_testTs,
			'deployment[description]' => 'Testingz'),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		return $this->getIdFromHref('deployments', $command->getResponse()->getHeader('Location'));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateOneDeployment
	 */
	public function testCanDestroyDeployment($depl_id) {
		$command = null;
		$result = $this->executeCommand('deployments_destroy', array('id' => $depl_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetAllDeploymentsJson() {				
		$depl = $this->executeCommand('deployments');
		
		$json_obj = json_decode($depl->getBody(true));
		
		$this->assertEquals(200, $depl->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));
	}	
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetAllDeploymentsXml() {
		$command = null;				
		$depl = $this->executeCommand('deployments', array('output_format' => '.xml'), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertNotNull($depl);
		$this->assertInstanceOf('SimpleXMLElement', $depl);
		$this->assertGreaterThan(0, count($depl));
	}	
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentsWithOneFilterJson() {
		$command = null;
		$depl_result = $this->executeCommand('deployments',
			array('filter' => "nickname=Guzzle_Test_" . self::$testTs),
			$command,
			'with_one_filter'
		);
		
		$json_obj = json_decode($depl_result->getBody(true));
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentsWithTwoFiltersJson() {
		$command = null;
		$depl_result = $this->executeCommand('deployments',
			array('filter' => array("nickname=Guzzle_Test_". self::$testTs, "description=This'll stick around for a bit")),
			$command,
			'with_two_filters'
		);
		
		$json_obj = json_decode($depl_result->getBody(true));
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentsWithOneFilterXml() {
		$command = null;
		$depl_result = $this->executeCommand('deployments',
			array('filter' => array("nickname=Guzzle_Test_" . self::$testTs), "output_format" => ".xml"),
			$command,
			'with_one_filter'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertEquals(1, count($depl_result));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentsWithTwoFiltersXml() {
		$command = null;
		$depl_result = $this->executeCommand('deployments',
			array('filter' => array("nickname=Guzzle_Test_" . self::$testTs, "description=This'll stick around for a bit"), "output_format" => ".xml"),
			$command,
			'with_two_filters'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertEquals(1, count($depl_result));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentByIdJson() {
		$command = null;		
		$depl_by_id_result = $this->executeCommand('deployment', array('id' => self::$_deployment->id), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Deployment', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $depl_by_id_result->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentByIdXml() {
		$command = null;		
		$depl_by_id_result = $this->executeCommand('deployment', array('id' => self::$_deployment->id, 'output_format' => '.xml'), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Deployment', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $depl_by_id_result->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentByIdWithServerSettingsJson() {
		$command = null;		
		$depl_by_id_result = $this->executeCommand('deployment',
			array('id' => self::$_deployment->id, 'server_settings' => 'true'),
			$command,
			'with_server_settings'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Deployment', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $depl_by_id_result->nickname);
		// TODO Not actually testing for servers with server settings, since no servers have been added
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetDeploymentByIdWithServerSettingsXml() {
		$command = null;		
		$depl_by_id_result = $this->executeCommand('deployment',
			array('id' => self::$_deployment->id, 'server_settings' => 'true', 'output_format' => '.xml'),
			$command,
			'with_server_settings'
		);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Deployment', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_" . self::$testTs, $depl_by_id_result->nickname);
		// TODO Not actually testing for servers with server settings, since no servers have been added
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateDeploymentDescription() {
		$command = null;
		$result = $this->executeCommand('deployment', array('id' => self::$_deployment->id), $command);
				
		$this->assertEquals("This'll stick around for a bit", $result->description);
				
		$result = $this->executeCommand('deployments_update', array('id' => self::$_deployment->id,
				'deployment[description]' => 'foobarbaz'
			),
			$command,
			'description'
		);
		
		$this->assertEquals(204, $result->getStatusCode());
		$this->assertEmpty($result->getBody(true));

		$result = $this->executeCommand('deployment', array('id' => self::$_deployment->id));
		
		$this->assertEquals('foobarbaz', $result->description);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanNotUpdateDeploymentDefaultAZ() {
		$command = null;		
		$cmd = $this->executeCommand('deployments_update',
			array('id' => self::$_deployment->id, 'deployment[default-ec2-availability-zone]' => 'us-east-1a'),
			$command,
			'default_az'
		);
		
		// This is the success response, indicating that the field was updated
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$result = $this->executeCommand('deployment', array('id' => self::$_deployment->id));
		
		// This should equal 'us-east-1a' as set above, but it's unchanged.
		$this->assertEquals('', strval($result->default_ec2_availability_zone));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanNotUpdateDefaultVpcHref() {
		$command = null;		
		$cmd = $this->executeCommand('deployments_update',
			array('id' => self::$_deployment->id, 'deployment[default-vpc-subnet-href]' => 'https://foo.bar'),
			$command,
			'default_vpc_href'
		);
		
		// This is the success response, indicating that the field was updated.
		// There should also be some validation that checks for the href existing, and belonging to a VPC subnet
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$result = $this->executeCommand('deployment', array('id' => self::$_deployment->id));
		
		// This should equal 'https://foo.bar' as set above, but it's unchanged.
		$this->assertEquals('', strval($result->default_vpc_subnet_href));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateDeploymentParameters() {
		$command = null;
		$cmd = $this->executeCommand('deployments_update', array('id' => self::$_deployment->id,
				'deployment[parameters]' => array(
						'APPLICATION' => 'text:foo',
						'LB_HOSTNAME' => 'text:bar'
				)
			),
			$command,
			'parameters'
		);
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$cmd = $this->_client->getCommand('deployment', array('id' => self::$_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// Can't get parameters, so no exception thrown is as good as it gets.
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanDuplicateDeploymentById() {
		$result = $this->executeCommand('deployments_duplicate', array('id' => self::$_deployment->id));
		
		$this->assertEquals(201, $result->getStatusCode());
		
		$deployment_id = $this->getIdFromHref('deployments', $result->getHeader('Location'));
		
		$cmd = $this->_client->getCommand('deployments_destroy', array('id' => $deployment_id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanStartAllServers() {
		$result = $this->executeCommand('deployments_start_all', array('id' => self::$_deployment->id));
		
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanStopAllServers() {
		$result = $this->executeCommand('deployments_stop_all', array('id' => self::$_deployment->id));
		
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testStartAllServersReturns500WhenServersCanNotBeStarted() {
		$this->markTestIncomplete("Need to create a deployment, add servers, but leave inputs blank");
	}

}

