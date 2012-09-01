<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Model\Ec2\MultiCloudImage;

class MultiCloudImageCommandsTest extends ClientCommandsBase {
	
	protected $mci_id;

	protected function setUp() {
		parent::setUp();
		
		$mci = new MultiCloudImage();
		$list = $mci->index();
		
		$this->mci_id = $list[0]->id;		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetMCIByIdJson() {
		$command = null;
		$mci = $this->executeCommand('multi_cloud_image', array('id' => $this->mci_id), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
		$this->assertNotNull($mci);
		$this->assertEquals($this->mci_id, $mci->id);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanGetMCIByIdXml() {
		$command = null;
		$mci = $this->executeCommand('multi_cloud_image', array('id' => $this->mci_id, 'output_format' => '.xml'), $command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertNotNull($mci);
		$this->assertEquals($this->mci_id, $mci->id);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListAllMCIsJson() {
		$this->markTestIncomplete("Not yet implemented");
	}
	
}

?>