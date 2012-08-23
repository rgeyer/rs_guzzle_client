<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class EbsSnapshotCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_ebsvol_href;
	protected static $_ebssnap_href;
	
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
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('ec2_ebs_snapshots_create',
				array(
						'ec2_ebs_snapshot[nickname]' => 'Guzzle_Test_For_EBS_' . self::$testTs,
						'ec2_ebs_snapshot[description]' => 'described',
						'ec2_ebs_snapshot[ec2_ebs_volume_id]' => $testClassToApproximateThis->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)
				),
				$command
		);
		
		self::$_ebssnap_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new EbsVolumeCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$ebsvol_id = $testClassToApproximateThis->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href);		
		$testClassToApproximateThis->executeCommand('ec2_ebs_volumes_destroy', array('id' => $ebsvol_id));
		
		$ebssnap_id = $testClassToApproximateThis->getIdFromHref('ec2_ebs_snapshots', self::$_ebssnap_href);		
		$testClassToApproximateThis->executeCommand('ec2_ebs_snapshots_destroy', array('id' => $ebssnap_id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateEbsSnapshot() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_snapshots_create',
				array(
						'ec2_ebs_snapshot[nickname]' => 'Guzzle_Test_For_EBS_' . $this->_testTs,
						'ec2_ebs_snapshot[description]' => 'described',
						'ec2_ebs_snapshot[ec2_ebs_volume_id]' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)
				),
				$command
		);
	
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
	
		$snap_id = $this->getIdFromHref('ec2_ebs_snapshots', $command->getResponse()->getHeader('Location'));
	
		return $snap_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateEbsSnapshot
	 */
	public function testCanDestroyEbsSnapshot($snap_id) {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_snapshots_destroy', array('id' => $snap_id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListEbsSnapshotsJson() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_snapshots', array(), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotNull($json_obj);
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListEbsSnapshotsXml() {
		$propname = 'ec2-ebs-snapshot';
		$command = null;
		$result = $this->executeCommand('ec2_ebs_snapshots', array('output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result->$propname));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowEbsSnapshotJson() {
		$command = null;
		$result = $this->executeCommand('ec2_ebs_snapshot', array('id' => $this->getIdFromHref('ec2_ebs_snapshots', self::$_ebssnap_href)), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));		
		$this->assertNotNull($json_obj);
		$this->assertEquals('described', $json_obj->description);
		$this->assertEquals($this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href), $json_obj->ec2_ebs_volume_id);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowEbsSnapshotXml() {
		$propname = 'ec2-ebs-volume-id';
		$command = null;
		$result = $this->executeCommand('ec2_ebs_snapshot', array('id' => $this->getIdFromHref('ec2_ebs_snapshots', self::$_ebssnap_href), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('described', $result->description);
		$this->assertEquals($this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href), $result->$propname);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateEbsSnapshotCommitState() {
		$this->markTestSkipped('Can not test because the API does not return commit_state');
	}
}