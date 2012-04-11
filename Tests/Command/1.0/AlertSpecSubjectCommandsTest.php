<?php
namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Model\Server;

use Guzzle\Rs\Model\SecurityGroup;

use Guzzle\Rs\Model\Deployment;

use Guzzle\Rs\Model\SshKey;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class AlertSpecSubjectCommandsTest extends ClientCommandsBase {
	
	protected $_ssh_key;
	protected $_deployment;
	protected $_security_group;
	protected $_server;
	protected $_alert_spec;
	
	protected function setUp() {
		parent::setUp();
		
		$testTs = time();
		$this->_ssh_key = new SshKey();
		$this->_ssh_key->aws_key_name = "Guzzle_Test_For_Alert_Spec_Subject_" . $testTs;
		$this->_ssh_key->create();
		
		$this->_deployment = new Deployment();
		$this->_deployment->nickname = "Guzzle_Test_For_Alert_Spec_Subject_" . $testTs;
		$this->_deployment->description = 'described';
		$this->_deployment->create();
		
		$this->_security_group = new SecurityGroup();
		$this->_security_group->aws_group_name = "Guzzle_Test_For_Alert_Spec_Subject_" . $testTs;
		$this->_security_group->aws_description = "described";
		$this->_security_group->create();
		
		$params = array(
				'server[nickname]' => "Guzzle_Test_For_Alert_Spec_Subject_" . $testTs,
				'server[server_template_href]' => $this->_serverTemplate->href,
				'server[ec2_ssh_key_href]' => $this->_ssh_key->href,
				'server[ec2_security_groups_href]' => array($this->_security_group->href),
				'server[deployment_href]' => $this->_deployment->href
		);
		$this->_server = new Server();
		$this->_server->create($params);
		
		$command = null;
		$result = $this->executeCommand('alert_specs', array(), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));
		
		$this->_alert_spec = $json_obj[0];
	}
	
	protected function tearDown() {
		$this->_deployment->destroy();
		$this->_ssh_key->destroy();
		$this->_security_group->destroy();
		
		parent::tearDown();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateAlertSpecSubject() {
		$command = null;
		$this->executeCommand('alert_spec_subjects_create',
			array(
				'alert_spec_subject[alert_spec_href]' => $this->_alert_spec->href,
				'alert_spec_subject[subject_href]' => $this->_server->href,
				'alert_spec_subject[subject_type]' => 'Server'
			),
			&$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());		
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$alert_subject_id = $this->getIdFromHref('alert_specs', $command->getResponse()->getHeader('Location'));
				
		$this->assertNotNull($alert_subject_id);
	}
}