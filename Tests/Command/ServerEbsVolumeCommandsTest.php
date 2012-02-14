<?php
namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Model\Server;

use Guzzle\Rs\Model\SecurityGroup;
use Guzzle\Rs\Model\Deployment;
use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class ServerEbsVolumeCommandsTest extends ClientCommandsBase {
	protected static $testTs;
	protected static $_deployment;
	protected static $_security_group;
	protected static $_ssh_key;
	protected static $_server;
	protected static $_ebsvol_href;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		self::$_ssh_key = new SshKey();
		self::$_ssh_key->aws_key_name = "Guzzle_Test_For_Component_Ebs_Volume_" . self::$testTs;
		self::$_ssh_key->create();
		
		self::$_deployment = new Deployment();
		self::$_deployment->nickname = "Guzzle_Test_For_Component_Ebs_Volume_" . self::$testTs;
		self::$_deployment->description = 'described';
		self::$_deployment->create();
		
		self::$_security_group = new SecurityGroup();
		self::$_security_group->aws_group_name = "Guzzle_Test_For_Component_Ebs_Volume_" . self::$testTs;
		self::$_security_group->aws_description = "described";
		self::$_security_group->create();
		
		$testClassToApproximateThis = new ServerEbsVolumeCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$params = array(
				'server[nickname]' => "Guzzle_Test_For_Component_Ebs_Volume_" . self::$testTs,
				'server[server_template_href]' => $testClassToApproximateThis->_serverTemplate->href,
				'server[ec2_ssh_key_href]' => self::$_ssh_key->href,
				'server[ec2_security_groups_href]' => array(self::$_security_group->href),
				'server[deployment_href]' => self::$_deployment->href
		);
		self::$_server = new Server();
		self::$_server->create($params);		
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('ec2_ebs_volumes_create',
			array(
					'ec2_ebs_volume[nickname]' => 'Guzzle_Test_For_Component_Ebs_Volume_' . self::$testTs,
					'ec2_ebs_volume[description]' => 'described',
					'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1a',
					'ec2_ebs_volume[aws_size]' => 1,
					'cloud_id' => 1
			),
			&$command
		);
		
		self::$_ebsvol_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {
		// No need to delete the server(s) this contains.
		self::$_deployment->destroy();
		
		self::$_ssh_key->destroy();
		
		self::$_security_group->destroy();

		$regex = ',https://.+/api/acct/[0-9]+/ec2_ebs_volumes/([0-9]+),';
		$matches = array();
		preg_match($regex, self::$_ebsvol_href, $matches);
		
		$vol_id = $matches[1];
		
		$testClassToApproximateThis = new ServerEbsVolumeCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$testClassToApproximateThis->executeCommand('ec2_ebs_volumes_destroy', array('id' => $vol_id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateEbsVolMappingToServer() {
		$command = null;
		$result = $this->executeCommand('component_ec2_ebs_volumes_create',
			array(
				'component_ec2_ebs_volume[component_href]' => self::$_server->href,
				'component_ec2_ebs_volume[ec2_ebs_volume_href]' => self::$_ebsvol_href,
				'component_ec2_ebs_volume[device]' => '/dev/sdh'
			),
			&$command
		);
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$regex = ',https://.+/api/acct/[0-9]+/component_ec2_ebs_volumes/([0-9]+),';
		$matches = array();
		preg_match($regex, $command->getResponse()->getHeader('Location'), $matches);
		
		$vol_id = $matches[1];
		
		return $vol_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateEbsVolMappingToServer
	 */
	public function testCanDestroyEbsVolMappingToServer($vol_id) {
		$command = null;
		$result = $this->executeCommand('component_ec2_ebs_volumes_destroy', array('id' => $vol_id), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
}