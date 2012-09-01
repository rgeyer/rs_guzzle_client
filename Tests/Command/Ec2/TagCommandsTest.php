<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Model\Ec2\Deployment;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class TagCommandsTest extends ClientCommandsBase {
		
	protected function setUp() {
		parent::setUp();
	}
	
	protected function tearDown() {
		parent::tearDown();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListTaggableResourcesJson() {
		$result = $this->executeCommand('tags_taggable_resources');
		
		$json_obj = json_decode($result->getBody(true));
		
		$expected_resource_list = array("Server","Ec2EbsSnapshot","Ec2EbsVolume","Ec2Image","Image","ServerArray","Ec2Instance","Instance","Deployment","ServerTemplate","MultiCloudImage");
		
		$this->assertEquals(11, count($json_obj));
		$this->assertEquals($expected_resource_list, $json_obj);
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListTaggableResourcesXml() {
		$command = null;
		$result = $this->executeCommand('tags_taggable_resources', array('output_format' => '.xml'), $command);
						
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals(11, count($result));		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanSetAndFindOneTag() {
		$deployment = new Deployment();
		$deployment->nickname = "Guzzle_Test_For_Tag_" . $this->_testTs;
		$deployment->description = 'described';
		$deployment->create();
		
		$result = $this->executeCommand('tags_set', array('resource_href' => $deployment->href, 'tags' => array('rs_guzzle_client:tagged=true')));		
		$this->assertEquals(204, $result->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_href' => $deployment->href), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(1, count($json_obj));
		$this->assertEquals('rs_guzzle_client:tagged=true', $json_obj[0]->name);
		
		return $deployment;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanSetAndFindOneTag
	 */
	public function testCanUnsetOneTag($deployment) {
		$result = $this->executeCommand('tags_unset', array('resource_href' => $deployment->href, 'tags' => array('rs_guzzle_client:tagged=true')));
		
		$this->assertEquals(204, $result->getStatusCode());
		
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_href' => $deployment->href), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());		
		$json_obj = json_decode($result->getBody(true));
		
		$this->assertEquals(0, count($json_obj));
		
		$deployment->destroy();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanSearchWithAllParamsJson() {		
		$deployment = new Deployment();
		$deployment->nickname = "Guzzle_Test_For_Tag_" . $this->_testTs;
		$deployment->description = 'described';
		$deployment->create();
		
		# Check for 0 tags first
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_href' => $deployment->href), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(0, count($json_obj));
		
		# Set one tag, then find it, this is duplicated above, but let's do it here for good measure
		$result = $this->executeCommand('tags_set', array('resource_href' => $deployment->href, 'tags' => array('rs_guzzle_client:tag1=true')));
		$this->assertEquals(204, $result->getStatusCode());
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_href' => $deployment->href), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(1, count($json_obj));
		
		# Set another tag, used for additional tests later
		$result = $this->executeCommand('tags_set', array('resource_href' => $deployment->href, 'tags' => array('rs_guzzle_client:tag2=true')));
		$this->assertEquals(204, $result->getStatusCode());
		
		# Search by deployment resource type
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_type' => 'Deployment', 'tags' => array('rs_guzzle_client:tag1=true')), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(1, count($json_obj));
		$hasSearchedTag = false;
		foreach($json_obj[0]->tags as $tag) {
			if($tag->name == 'rs_guzzle_client:tag1=true') {
				$hasSearchedTag = true;
			}				
		}
		$this->assertTrue($hasSearchedTag);
		
		# Search by different resource type
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_type' => 'Server', 'tags' => array('rs_guzzle_client:tag1=true')), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(0, count($json_obj));
		
		# Search with match_all		
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_type' => 'Deployment', 'tags' => array('rs_guzzle_client:tag1=true','rs_guzzle_client:tagfoo=true'), 'match_all' => 'true'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals(0, count($json_obj));
		
		$deployment->destroy();
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanSearchWithAllParamsXml() {		
		$deployment = new Deployment();
		$deployment->nickname = "Guzzle_Test_For_Tag_" . $this->_testTs;
		$deployment->description = 'described';
		$deployment->create();
		
		# Check for 0 tags first
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_href' => $deployment->href, 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectNotHasAttribute('tag', $result);
		
		# Set one tag, then find it, this is duplicated above, but let's do it here for good measure
		$result = $this->executeCommand('tags_set', array('resource_href' => $deployment->href, 'tags' => array('rs_guzzle_client:tag1=true')));
		$this->assertEquals(204, $result->getStatusCode());
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_href' => $deployment->href, 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectHasAttribute('tag', $result);		
		$this->assertEquals(1, count($result->tag));
		
		# Set another tag, used for additional tests later
		$result = $this->executeCommand('tags_set', array('resource_href' => $deployment->href, 'tags' => array('rs_guzzle_client:tag2=true')));
		$this->assertEquals(204, $result->getStatusCode());
		
		# Search by deployment resource type
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_type' => 'Deployment', 'tags' => array('rs_guzzle_client:tag1=true'), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectHasAttribute('deployment', $result);		
		$this->assertEquals(2, count($result->deployment->tags->tag));
		$hasSearchedTag = false;
		foreach($result->deployment->tags->tag as $tag) {
			if($tag->name == 'rs_guzzle_client:tag1=true') {
				$hasSearchedTag = true;
			}				
		}
		$this->assertTrue($hasSearchedTag);
		
		# Search by different resource type
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_type' => 'Server', 'tags' => array('rs_guzzle_client:tag1=true'), 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectNotHasAttribute('tag', $result);
		
		# Search with match_all		
		$command = null;
		$result = $this->executeCommand('tags_search', array('resource_type' => 'Deployment', 'tags' => array('rs_guzzle_client:tag1=true','rs_guzzle_client:tagfoo=true'), 'match_all' => 'true', 'output_format' => '.xml'), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertObjectNotHasAttribute('tag', $result);
		
		$deployment->destroy();
	}
}

?>