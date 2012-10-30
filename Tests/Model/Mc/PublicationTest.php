<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\Publication;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class PublicationTest extends \Guzzle\Tests\GuzzleTestCase {

	protected function setUp() {
		parent::setUp();

		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testExtendsModelBase() {
    $pub = new Publication();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $pub);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/publication/json/response');
		$pub = new Publication();
    $pub->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Publication', $pub);
		$keys = array_keys($pub->getParameters());
		$expectedKeys = array(
	    'revision_notes',
	    'updated_at',
	    'publisher',
	    'content_type',
	    'commit_message',
	    'description',
	    'name',
	    'created_at',
	    'links',
	    'revision',
	    'actions',
	    'href',
	    'id'
    );				
		foreach($expectedKeys as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testImplementsImportMethod() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/publication/json/response',
  			'1.5/publications_import/response'
			)
  	);
  	$pub = new Publication();
  	$pub->find_by_id('12345');
  	$pub->import();
  	$command = $pub->getLastCommand();
  	$this->assertContains('/api/publications/12345/import', (string)$command->getRequest());
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportCreateMethod() {
		$pub = new Publication();
		$pub->create();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 * @expectedExceptionMessage publication does not implement an update method
	 */
	public function testDoesNotSupportUpdateMethod() {
		$pub = new Publication();
		$pub->update();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDestroyMethod() {
		$pub = new Publication();
		$pub->destroy();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDuplicateMethod() {
		$pub = new Publication();
		$pub->duplicate();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanGetLineageRelationship() {
  	$this->markTestSkipped('Lineage command(s) not yet implemented');
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/publication/json/response',
  			'1.5/lineage/json/response'
			)
  	);
  	$pub = new Publication();
  	$pub->find_by_id('12345');
  	$lineage = $pub->lineage();	  
  	$this->assertNotNull($lineage);
  	$this->assertInstanceOf('stdClass', $lineage);
	}

}