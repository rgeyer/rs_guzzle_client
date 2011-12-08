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
		
		#$this->assertGreaterThan(0, $list);
		
		$this->mci_id = $list[0]->id;		
	}
	
	public function testCanGetMCIById() {
		$mci = new MultiCloudImage();
		$mci->find_by_id($this->mci_id);
		
		$this->assertNotNull($mci);
		$this->assertEquals($this->mci_id, $mci->id);
	}
	
}

?>