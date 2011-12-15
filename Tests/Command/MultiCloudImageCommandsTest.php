<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use Guzzle\Rs\Model\MultiCloudImage;

class MultiCloudImageCommandsTest extends ClientCommandsBase {
	
	protected $mci_id;

	protected function setUp() {
		parent::setUp();
		
		$mci = new MultiCloudImage();
		$list = $mci->index();
		
		$this->mci_id = $list[0]->id;		
	}
	
	public function testCanGetMCIByIdJson() {
		$command = null;
		$mci = $this->executeCommand('multi_cloud_image', array('id' => $this->mci_id), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
		$this->assertNotNull($mci);
		$this->assertEquals($this->mci_id, $mci->id);
	}
	
	public function testCanGetMCIByIdXml() {
		$command = null;
		$mci = $this->executeCommand('multi_cloud_image', array('id' => $this->mci_id, 'output_format' => '.xml'), &$command);
		
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertNotNull($mci);
		$this->assertEquals($this->mci_id, $mci->id);
	}
	
	public function testCanListAllMCIsJson() {
		
	}
	
}

?>