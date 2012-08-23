<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class S3BucketCommandsTest extends ClientCommandsBase {
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateS3Bucket() {
		$command = null;
		$result = $this->executeCommand('s3_buckets_create', array('s3_bucket[name]' => 'RS_Guzzle_Tests_' . $this->_testTs), $command);
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		return $this->getIdFromHref('s3_buckets', $command->getResponse()->getHeader('Location'));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateS3Bucket
	 */
	public function testCanDestroyS3Bucket($bucketId) {
		$command = null;
		$result = $this->executeCommand('s3_buckets_destroy', array('id' => $bucketId), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
}