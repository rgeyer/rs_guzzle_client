<?php
namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SqsQueuesTest extends ClientCommandsBase {
	
	public static function setUpBeforeClass() {
		
	}
	
	public static function tearDownAfterClass() {
		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateSqsQueue() {
		$this->markTestSkipped("Even with correct parameters, this throws 422!");
		$command = null;
		$result = $this->executeCommand('sqs_queues_create',
			array(
				'sqs_queue[name]' => 'GT',
				'sqs_queue[api_generation]' => 1
			),
			&$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$sqs_id = $this->getIdFromHref('sqs_queues', $command->getResponse()->getHeader('Location'));
		
		return $sqs_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
 	 * @depends testCanCreateSqsQueue
	 */
	public function testCanDestroySqsQueue($id) {
		$command = null;
		$result = $this->executeCommand('sqs_queues_destroy', array('id' => $id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
	}
	
}