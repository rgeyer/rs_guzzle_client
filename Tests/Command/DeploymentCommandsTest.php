<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use Guzzle\Rs\Model\Deployment;

class DeploymentCommandsTest extends ClientCommandsBase {
	
	protected $_deployment;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->_deployment = new Deployment();
		$this->_deployment->nickname = "Guzzle_Test_$this->_testTs";
		$this->_deployment->description = "This'll stick around for a bit";  		
		$this->_deployment->create();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$cmd = $this->_client->getCommand('deployments_destroy', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();

		parent::tearDown ();
	}
	
	public function testCanCreateAndDeleteOneDeployment() {		
		$result = new Deployment();
		$result->nickname = "Guzzle Integration Test_" . $this->_testTs;
		$result->description = "Testingz";
		$result->create();
		
		$cmd = $this->_client->getCommand('deployments_destroy', array('id' => $result->id));
		$response = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	public function testCanGetAllDeployments() {				
		$depl_cmd = $this->_client->getCommand('deployments');		
		$depl_resp = $depl_cmd->execute();
		$depl_result = $depl_cmd->getResult();
		
		$json_obj = json_decode($depl_result->getBody(true));
		
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	public function testCanGetDeploymentsWithOneFilter() {
		$depl_cmd = $this->_client->getCommand('deployments', array('filter' => "nickname=Guzzle_Test_$this->_testTs"));		
		$depl_resp = $depl_cmd->execute();
		$depl_result = $depl_cmd->getResult();
		
		$json_obj = json_decode($depl_result->getBody(true));
		
		$this->assertNotNull($json_obj);
		$this->assertEquals(1, count($json_obj));
	}
	
	public function testCanGetDeploymentById() {		
		$depl_by_id_cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id));
		$depl_by_id_resp = $depl_by_id_cmd->execute();
		$depl_by_id_result = $depl_by_id_cmd->getResult();
		
		$this->assertInstanceOf('Guzzle\Rs\Model\Deployment', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $depl_by_id_result->nickname);
	}
	
	public function testCanGetDeploymentByIdWithServerSettings() {		
		$depl_by_id_cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id, 'server_settings' => 'true'));
		$depl_by_id_resp = $depl_by_id_cmd->execute();
		$depl_by_id_result = $depl_by_id_cmd->getResult();
		
		$this->assertInstanceOf('Guzzle\Rs\Model\Deployment', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $depl_by_id_result->nickname);
		// TODO Not actually testing for servers with server settings, since no servers have been added
	}
	
	public function testCanUpdateDeploymentDescription() {
		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals("This'll stick around for a bit", $result->description);
				
		$cmd = $this->_client->getCommand('deployments_update', array('id' => $this->_deployment->id,
				'deployment[description]' => 'foobarbaz'
			)
		);
		$resp = $cmd->execute();
		$result = $cmd->getResult();

		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals('foobarbaz', $result->description);
	}
	
	public function testCanNotUpdateDeploymentDefaultAZ() {		
		$cmd = $this->_client->getCommand('deployments_update', array('id' => $this->_deployment->id, 'deployment[default-ec2-availability-zone]' => 'us-east-1a'));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// This is the success response, indicating that the field was updated
		$this->assertEquals(204, $result->getStatusCode());
		
		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// This should equal 'us-east-1a' as set above, but it's unchanged.
		$this->assertEquals('', strval($result->default_ec2_availability_zone));
	}
	
	public function testCanNotUpdateDefaultVpcHref() {		
		$cmd = $this->_client->getCommand('deployments_update', array('id' => $this->_deployment->id, 'deployment[default-vpc-subnet-href]' => 'https://foo.bar'));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// This is the success response, indicating that the field was updated.
		// There should also be some validation that checks for the href existing, and belonging to a VPC subnet
		$this->assertEquals(204, $result->getStatusCode());
		
		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// This should equal 'https://foo.bar' as set above, but it's unchanged.
		$this->assertEquals('', strval($result->default_vpc_subnet_href));
	}
	
	public function testCanUpdateDeploymentParameters() {
		$cmd = $this->_client->getCommand('deployments_update', array('id' => $this->_deployment->id,
				'deployment[parameters]' => array(
						'APPLICATION' => 'text:foo',
						'LB_HOSTNAME' => 'text:bar'
				)
			)
		);
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// Can't get parameters, so no exception thrown is as good as it gets.
	}
	
	public function testCanDuplicateDeploymentById() {
		$cmd = $this->_client->getCommand('deployments_duplicate', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(201, $result->getStatusCode());
		
		$regex = ',https://my.rightscale.com/api/acct/[0-9]+/deployments/([0-9]+),';
		$location_header = $result->getHeader('Location');
		$matches = array();
		$this->assertEquals(1, preg_match($regex, $location_header, $matches));
		
		$cmd = $this->_client->getCommand('deployments_destroy', array('id' => $matches[1]));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
	}
	
	public function testCanStartAllServers() {
		$cmd = $this->_client->getCommand('deployments_start_all', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	public function testCanStopAllServers() {
		$cmd = $this->_client->getCommand('deployments_stop_all', array('id' => $this->_deployment->id));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	public function testStartAllServersReturns500WhenServersCanNotBeStarted() {
		$this->markTestIncomplete("Need to create a deployment, add servers, but leave inputs blank");
	}

}

