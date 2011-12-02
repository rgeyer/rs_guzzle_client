<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Common\RequestFactory;
use Guzzle\Rs\Tests\Common\ClientCommandsBase;

class DeploymentCommandsTest extends ClientCommandsBase {
	
	protected $_deploymentId;
	
	protected $_deploymentHref;
	
	protected $_deploymentXml;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();		
		$deployment = RequestFactory::createDeployment($this->_client, "Guzzle_Test_$this->_testTs", "This'll stick around for a bit");
		$regex = ',https://my.rightscale.com/api/acct/[0-9]+/deployments/([0-9]+),';
		$location_header = $deployment->getHeader('Location');
		$matches = array();
		preg_match($regex, $location_header, $matches);
		$this->_deploymentId = $matches[1];
		$this->_deploymentHref = $location_header;
		$this->_deploymentXml = $deployment;
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$cmd = $this->_client->getCommand('deployment_destroy', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();		

		parent::tearDown ();
	}
	
	public function testCanCreateAndDeleteOneDeployment() {
		$result = RequestFactory::createDeployment($this->_client, "Guzzle Integration Test_" . $this->_testTs, "Testingz");
		
		$regex = ',https://my.rightscale.com/api/acct/[0-9]+/deployments/([0-9]+),';
		$location_header = $result->getHeader('Location');
		$matches = array();
		
		$this->assertEquals(1, preg_match($regex, $location_header, $matches));
		
		$cmd = $this->_client->getCommand('deployment_destroy', array('id' => $matches[1]));
		$response = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	public function testCanGetAllDeployments() {				
		$depl_cmd = $this->_client->getCommand('deployments');		
		$depl_resp = $depl_cmd->execute();
		$depl_result = $depl_cmd->getResult();

		$this->assertInstanceOf('SimpleXMLElement', $depl_result);
		$this->assertGreaterThan(0, count($depl_result->deployment));
	}
	
	public function testCanGetDeploymentsWithOneFilter() {
		$depl_cmd = $this->_client->getCommand('deployments', array('filter' => 'nickname=Default'));		
		$depl_resp = $depl_cmd->execute();
		$depl_result = $depl_cmd->getResult();
		
		$this->assertInstanceOf('SimpleXMLElement', $depl_result);
		$this->assertEquals(1, count($depl_result->deployment));
	}
	
	public function testCanGetDeploymentById() {		
		$depl_by_id_cmd = $this->_client->getCommand('deployment', array('id' => $this->_deploymentId));
		$depl_by_id_resp = $depl_by_id_cmd->execute();
		$depl_by_id_result = $depl_by_id_cmd->getResult();
		
		$this->assertInstanceOf('SimpleXMLElement', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $depl_by_id_result->nickname);
	}
	
	public function testCanGetDeploymentByIdWithServerSettings() {		
		$depl_by_id_cmd = $this->_client->getCommand('deployment', array('id' => $this->_deploymentId, 'server_settings' => 'true'));
		$depl_by_id_resp = $depl_by_id_cmd->execute();
		$depl_by_id_result = $depl_by_id_cmd->getResult();
		
		$this->assertInstanceOf('SimpleXMLElement', $depl_by_id_result);
		$this->assertEquals("Guzzle_Test_$this->_testTs", $depl_by_id_result->nickname);
		// TODO Not actually testing for servers with server settings, since no servers have been added
	}
	
	public function testCanUpdateDeploymentDescription() {
		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals("This'll stick around for a bit", $result->description);
				
		$cmd = $this->_client->getCommand('deployment_update', array('id' => $this->_deploymentId,
				'deployment[description]' => 'foobarbaz'
			)
		);
		$resp = $cmd->execute();
		$result = $cmd->getResult();

		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals('foobarbaz', $result->description);
	}
	
	public function testCanUpdateDeploymentParameters() {
		$cmd = $this->_client->getCommand('deployment_update', array('id' => $this->_deploymentId,
				'deployment[parameters]' => array(
						'APPLICATION' => 'text:foo',
						'LB_HOSTNAME' => 'text:bar'
				)
			)
		);
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$cmd = $this->_client->getCommand('deployment', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		// Can't get parameters, so no exception thrown is as good as it gets.
	}
	
	public function testCanDuplicateDeploymentById() {
		$cmd = $this->_client->getCommand('deployment_duplicate', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$regex = ',https://my.rightscale.com/api/acct/[0-9]+/deployments/([0-9]+),';
		$location_header = $result->getHeader('Location');
		$matches = array();
		$this->assertEquals(1, preg_match($regex, $location_header, $matches));
		
		$cmd = $this->_client->getCommand('deployment_destroy', array('id' => $matches[1]));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
	}
	
	public function testCanStartAllServers() {
		$cmd = $this->_client->getCommand('deployment_start_all', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	public function testCanStopAllServers() {
		$cmd = $this->_client->getCommand('deployment_stop_all', array('id' => $this->_deploymentId));
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		$this->assertEquals(201, $result->getStatusCode());
	}
	
	public function testStartAllServersReturns500WhenServersCanNotBeStarted() {
		$this->markTestIncomplete("Need to create a deployment, add servers, but leave inputs blank");
	}

}

