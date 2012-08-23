<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Model\SshKey;
use RGeyer\Guzzle\Rs\Model\Deployment;
use RGeyer\Guzzle\Rs\Model\SecurityGroup;
use RGeyer\Guzzle\Rs\Model\Server;

class AlertSpecCommandsTest extends ClientCommandsBase {
	
	/**
	 * A timestamp for the test
	 * @var int
	 */
	protected static $testTs;
	
	/**
	 *
	 * @var Deployment
	 */
	protected static $_deployment;
	
	/**
	 *
	 * @var SecurityGroup
	 */
	protected static $_security_group;
	
	/**
	 *
	 * @var SshKey
	 */
	protected static $_ssh_key;
	
	/**
	 * 
	 * @var Server
	 */
	protected static $_server;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		self::$_ssh_key = new SshKey();
		self::$_ssh_key->aws_key_name = "Guzzle_Test_For_Alert_Spec_" . self::$testTs;
		self::$_ssh_key->create();
		
		self::$_deployment = new Deployment();
		self::$_deployment->nickname = "Guzzle_Test_For_Alert_Spec_" . self::$testTs;
		self::$_deployment->description = 'described';
		self::$_deployment->create();
		
		self::$_security_group = new SecurityGroup();
		self::$_security_group->aws_group_name = "Guzzle_Test_For_Alert_Spec_" . self::$testTs;
		self::$_security_group->aws_description = "described";
		self::$_security_group->create();
		
		$testClassToApproximateThis = new AlertSpecCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$params = array(
				'server[nickname]' => "Guzzle_Test_For_Alert_Spec_" . self::$testTs,
				'server[server_template_href]' => $testClassToApproximateThis->_serverTemplate->href,
				'server[ec2_ssh_key_href]' => self::$_ssh_key->href,
				'server[ec2_security_groups_href]' => array(self::$_security_group->href),
				'server[deployment_href]' => self::$_deployment->href
		);
		self::$_server = new Server();
		self::$_server->create($params);
	}
	
	public static function tearDownAfterClass() {
		// No need to delete the server(s) this contains.
		self::$_deployment->destroy();
		
		self::$_ssh_key->destroy();
		
		self::$_security_group->destroy();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAlertSpecsJson() {
		$command = null;
		$result = $this->executeCommand('alert_specs', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAlertSpecsXml() {
		$command = null;
		$result = $this->executeCommand('alert_specs', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$attrname = 'alert-spec';
		$this->assertObjectHasAttribute($attrname, $result);
		$this->assertGreaterThan(0, count($result->$attrname));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowOneAlertSpecJson() {
		$command = null;
		$result = $this->executeCommand('alert_specs', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));
		
		$alert_spec = $json_obj[0];
		
		$alert_id = $this->getIdFromHref('alert_specs', $alert_spec->href);

		$command = null;
		$result = $this->executeCommand('alert_spec', array('id' => $alert_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(1, count($json_obj));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowOneAlertSpecXml() {
		$command = null;
		$result = $this->executeCommand('alert_specs', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));
		
		$alert_spec = $json_obj[0];
		
		$alert_id = $this->getIdFromHref('alert_specs', $alert_spec->href);

		$command = null;
		$result = $this->executeCommand('alert_spec', array('id' => $alert_id, 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectHasAttribute('href', $result);		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateAnEscalationAlertSpec() {
		$command = null;
		$result = $this->executeCommand('alert_specs_create', array(
				'alert_spec[name]' => 'rs guzzle test alert',
				'alert_spec[file]' => 'memory/memory_free',
				'alert_spec[variable]' => 'value',
				'alert_spec[condition]' => '<',
				'alert_spec[threshold]' => '1000000',
				'alert_spec[escalation_name]' => 'critical',
				'alert_spec[duration]' => 1,
				'alert_spec[description]' => 'A quick description',
				'alert_spec[subject_type]' => 'Server',
				'alert_spec[subject_href]' => self::$_server->href,
				'alert_spec[action]' => 'escalate'
			), $command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$alert_id = $this->getIdFromHref('alert_specs', $command->getResponse()->getHeader('Location'));
		
		return $alert_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateAVoteAlertSpec() {
		$command = null;
		$result = $this->executeCommand('alert_specs_create', array(
				'alert_spec[name]' => 'rs guzzle test alert',
				'alert_spec[file]' => 'memory/memory_free',
				'alert_spec[variable]' => 'value',
				'alert_spec[condition]' => '<',
				'alert_spec[threshold]' => '1000000',
				'alert_spec[duration]' => 1,
				'alert_spec[description]' => 'A quick description',
				'alert_spec[subject_type]' => 'Server',
				'alert_spec[subject_href]' => self::$_server->href,
				'alert_spec[action]' => 'vote',
				'alert_spec[vote_tag]' => 'foo:bar=baz',
				'alert_spec[vote_type]' => 'grow'
			), $command);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		$alert_spec_id = $this->getIdFromHref('alert_specs', $command->getResponse()->getHeader('Location'));
		
		return $alert_spec_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateAVoteAlertSpec
	 */
	public function testCanDestroyAlertSpec($alert_spec_id) {
		$command = null;
		$result = $this->executeCommand('alert_specs_destroy', array('id' => $alert_spec_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateAnEscalationAlertSpec
	 */
	public function testCanUpdateAnAlertSpec($alert_id) {		
		$command = null;
		$result = $this->executeCommand('alert_spec', array('id' => $alert_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(1, count($json_obj));
		$this->assertEquals($json_obj->name, 'rs guzzle test alert');
		
		$command = null;
		$result = $this->executeCommand('alert_specs_update', array(
				'id' => $alert_id,
				'alert_spec[name]' => 'rs guzzle test alertzor'
			), $command);
		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());

		
		$command = null;
		$result = $this->executeCommand('alert_spec', array('id' => $alert_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(1, count($json_obj));
		$this->assertEquals($json_obj->name, 'rs guzzle test alertzor');
	}
	
}