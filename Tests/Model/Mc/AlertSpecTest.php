<?php
namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use Guzzle\Tests\GuzzleTestCase;

use RGeyer\Guzzle\Rs\Model\Mc\AlertSpec;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class AlertSpecTest extends GuzzleTestCase {

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
    $spec = new AlertSpec();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $spec);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/alert_spec/json/response');
		$spec = new AlertSpec();
    $spec->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\AlertSpec', $spec);
		$keys = array_keys($spec->getParameters());
		$expectedKeys = array(
	    'alert_spec[variable]',
	    'updated_at',
	    'alert_spec[duration]',
	    'alert_spec[file]',
	    'alert_spec[threshold]',
	    'actions',
	    'alert_spec[escalation_name]',
	    'alert_spec[condition]',
	    'created_at',
	    'alert_spec[description]',
	    'alert_spec[name]',
	    'links',
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
   * @expectedException BadMethodCallException
   * @expectedExceptionMessage alert_spec does not implement a duplicate method
   */
  public function testAlertSpecDoesNotImplementDuplidate() {
    $spec = new AlertSpec();
    $spec->duplicate();
  }
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 * @expectedExceptionMessage There was no link for "subject" returned by the API
	 */
	public function testSubjectMethodThrowsExceptionWhenNoSubjectLinkAvailable() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/alert_spec/json/response',
  			'1.5/server/json/response'
			)
  	);
  	$spec = new AlertSpec();
  	$spec->find_by_id('12345');
  	$spec->links = array();
  	$spec->subject();  		  
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException UnexpectedValueException
	 * @expectedExceptionMessage The href for subject (/api/123_something/12345) did not match the regex (,/api/([a-z_]*)s/,)
	 */
	public function testSubjectMethodThrowsExceptionWhenSubjectLinkIsInvalid() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/alert_spec/json/response',
  			'1.5/server/json/response'
			)
  	);
  	$spec = new AlertSpec();
  	$spec->find_by_id('12345');
  	$spec->links[1]->href = '/api/123_something/12345';
  	$spec->subject();  		  
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetSubjectRelationshipWhenSubjectIsServer() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/alert_spec/json/response',
  			'1.5/server/json/response'
			)
  	);
  	$spec = new AlertSpec();
  	$spec->find_by_id('12345');
  	$spec->links[1]->href = '/api/servers/12345';
  	$server = $spec->subject();
  	$command = $spec->getLastCommand();
  	$request = (string)$command->getRequest();
  	
  	$this->assertNotNull($server);
  	$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Server', $server);
  	$this->assertContains('/api/servers/1234', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetSubjectRelationshipWhenSubjectIsServerArray() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/alert_spec/json/response',
  			'1.5/server_array/json/response'
			)
  	);
  	$spec = new AlertSpec();
  	$spec->find_by_id('12345');
  	$spec->links[1]->href = '/api/server_arrays/12345';
  	$serverAry = $spec->subject();
  	$command = $spec->getLastCommand();
  	$request = (string)$command->getRequest();
  	
  	$this->assertNotNull($serverAry);
  	$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerArray', $serverAry);
  	$this->assertContains('/api/server_arrays/1234', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetSubjectRelationshipWhenSubjectIsServerTemplate() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/alert_spec/json/response',
  			'1.5/server_template/json/response'
			)
  	);
  	$spec = new AlertSpec();
  	$spec->find_by_id('12345');
  	$spec->links[1]->href = '/api/server_templates/12345';
  	$serverTemp = $spec->subject();
  	$command = $spec->getLastCommand();
  	$request = (string)$command->getRequest();
  	
  	$this->assertNotNull($serverTemp);
  	$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $serverTemp);
  	$this->assertContains('/api/server_templates/1234', $request);
  }  
}