<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class EbsVolumeCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_ebsvol_href;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		$testClassToApproximateThis = new EbsVolumeCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('ec2_ebs_volumes_create',
				array(
						'ec2_ebs_volume[nickname]' => 'Guzzle_Test_For_EBS_' . self::$testTs,
						'ec2_ebs_volume[description]' => 'described',
						'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1a',
						'ec2_ebs_volume[aws_size]' => 1,
						'cloud_id' => 1
				),
				$command
		);
		
		self::$_ebsvol_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new EbsVolumeCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$ebsvol_id = $testClassToApproximateThis->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href);
		
		$testClassToApproximateThis->executeCommand('ec2_ebs_volumes_destroy', array('id' => $ebsvol_id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateEbsVolume() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volumes_create',
			array(
				'ec2_ebs_volume[nickname]' => 'Guzzle_Test_For_EBS_' . $this->_testTs,
				'ec2_ebs_volume[description]' => 'described',
				'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1a',
				'ec2_ebs_volume[aws_size]' => 1,
				'cloud_id' => 1
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$vol_id = $this->getIdFromHref('ec2_ebs_volumes', $command->getResponse()->getHeader('Location'));
		
		return $vol_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateEbsVolume
	 */
	public function testCanDestroyEbsVolume($vol_id) {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volumes_destroy', array('id' => $vol_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListEbsVolumesJson() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volumes', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListEbsVolumesXml() {
		$propname = 'ec2-ebs-volume';
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volumes', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result->$propname));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowEbsVolumeJson() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('described', $json_obj->description);
		$this->assertEquals(1, $json_obj->aws_size);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowEbsVolumeXml() {
		$propname = 'aws-size';
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('described', $result->description);
		$this->assertEquals(1, intval($result->$propname));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateEbsVolumeNickname() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertNotEquals('NewNickname', $json_obj->nickname);
		
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volumes_update',
			array(
				'id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href),
				'ec2_ebs_volume[nickname]' => 'NewNickname'),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('NewNickname', $json_obj->nickname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateEbsVolumeDescription() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertNotEquals('NewDescription', $json_obj->description);
		
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volumes_update',
			array(
				'id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href),
				'ec2_ebs_volume[description]' => 'NewDescription'),
			$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertEquals('NewDescription', $json_obj->description);
	}
}