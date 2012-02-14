<?php
namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class EbsVolumeCommandsTest extends ClientCommandsBase {
	
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
			&$command
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
		$result = $this->executeCommand('ec2_ebs_volumes_destroy', array('id' => $vol_id), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
}