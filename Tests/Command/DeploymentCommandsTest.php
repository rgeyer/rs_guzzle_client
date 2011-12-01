<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Http\Plugin\CookiePlugin;
use Guzzle\Http\CookieJar\ArrayCookieJar;
use Guzzle\Http\Message\Response;

/**
 * test case.
 */
class DeploymentCommandsTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected $_client;
	
	protected $_testTs;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$this->_testTs = time();
		
		$this->_client = $this->getServiceBuilder()->get('test.guzzle-rs-1_0');
		$login_cmd = $this->_client->getCommand('login', array('email' => $_SERVER['EMAIL'], 'password' => $_SERVER['PASSWORD']));
		$login_resp = $login_cmd->execute();
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated LoginCommandTest::tearDown()
		

		parent::tearDown ();
	}
	
	protected function createDeployment($nickname, $description, $default_vpc_subnet = null, $default_ec2_az = null) {
		$param_ary = array('deployment[nickname]' => $nickname, 'deployment[description]' => $description);
		
		if($default_vpc_subnet) {
			$param_ary['deployment[default_vpc_subnet_href]'] = $default_vpc_subnet;
		}
		
		if($default_ec2_az) { $param_ary['deployment[default_ec2_availability_zone]'] = $default_ec2_az; }
		
		$cmd = $this->_client->getCommand('deployment_create', $param_ary);		
		$resp = $cmd->execute();
		$result = $cmd->getResult();
		
		return $result;
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	public function testCanCreateAndDeleteOneDeployment() {
		$result = $this->createDeployment("Guzzle Integration Test_" . $this->_testTs, "Testingz");
		
		$regex = ',https://my.rightscale.com/api/acct/[0-9]+/deployments/([0-9]+),';
		$location_header = $result->getHeader('Location');
		$matches = array();
		
		$this->assertEquals(1, preg_match($regex, $location_header, $matches));
		
		$cmd = $this->_client->getCommand('deployment_delete', array('id' => $matches[1]));
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
		$depl_cmd = $this->_client->getCommand('deployments', array('filter' => 'nickname=Default'));
		$depl_resp = $depl_cmd->execute();
		$depl_result = $depl_cmd->getResult();
		
		$href = $depl_result->deployment[0]->href;
		$matches = array();
		preg_match(",https://my.rightscale.com/api/acct/[0-9]+/deployments/(.+),", $href, $matches);
		
		$depl_by_id_cmd = $this->_client->getCommand('deployment', array('id' => $matches[1]));
		$depl_by_id_resp = $depl_by_id_cmd->execute();
		$depl_by_id_result = $depl_by_id_cmd->getResult();
		
		$this->assertInstanceOf('SimpleXMLElement', $depl_by_id_result);
		$this->assertEquals('Default', $depl_by_id_result->nickname);
	}
	
	public function testCanGetDeploymentByIdWithServerSettings() {
		$depl_cmd = $this->_client->getCommand('deployments', array('filter' => 'nickname=Default'));
		$depl_resp = $depl_cmd->execute();
		$depl_result = $depl_cmd->getResult();
		
		$href = $depl_result->deployment[0]->href;
		$matches = array();
		preg_match(",https://my.rightscale.com/api/acct/[0-9]+/deployments/(.+),", $href, $matches);
		
		$depl_by_id_cmd = $this->_client->getCommand('deployment', array('id' => $matches[1], 'server_settings' => 'true'));
		$depl_by_id_resp = $depl_by_id_cmd->execute();
		$depl_by_id_result = $depl_by_id_cmd->getResult();
		
		$this->assertInstanceOf('SimpleXMLElement', $depl_by_id_result);
		$this->assertEquals('Default', $depl_by_id_result->nickname);
	}
	
	public function testVersion() {
		$client = $this->getServiceBuilder()->get('test.guzzle-rs-1_0');
		$this->assertEquals('1.0', $client->getVersion());
	}
	
// 	public function testCookieStuffWorks() {
// 		$cookieJar = new ArrayCookieJar();
// 		$cookiePlugin = new CookiePlugin($cookieJar);		
		
// 		$headerAry = array(
// 			'Set-Cookie' => 'rs_gbl=eNotkNtugkAURX-lOc-Mcc4IDCRN6qVVEbWoiZcXM8CoEC4tF0GM_15I-r7WTvZ6ggAT4gco4OdgPqHMZQbmACnjLwUKD0zKEDWdYx8VCPyWZhdDcwcaJ9TlSCiVlBi6MAhFRpmPjPmaaPcK-e9yddC57TysDpEc74JkldVpVDmu7genhMaj6cS-l8PL2vo93Azk9VagdsvQJqvNkqv6p_9TUqvZuSQIKS-3RRq4RUnqxh7dxuy8P9jTxna-5dyrrGa2H6j7taXLBZmGI1x-DaNZVaF3vudqyP1IHzZOHp7jZTxZJGtsDkdyXGja_uEjwXq-uchtcHL4e5ek7pIkIm6vwOYhkrepfLR9FBCel5ZJASbDvqEqIGMRRC2UtVDv2kEfWXC9FbknItnz0hherz-gCW7u; domain=.rightscale.com; path=/; HttpOnly'/*,
// 			'Set-Cookie' => '_session_id=c02425707d0c9c18608fe7b021bf98dc; path=/; Secure; HttpOnly'*/
// 				); 
		
// 		$response = new Response(204, $headerAry, "body");
		
// 		$cookiePlugin->extractCookies($response);
		
// 		print_r($cookieJar->getCookies('my.rightscale.com'));		
// 	}

}

