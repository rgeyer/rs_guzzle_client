<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use Guzzle\Tests\GuzzleTestCase;

use RGeyer\Guzzle\Rs\Model\Mc\ServerArray;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerArrayTest extends GuzzleTestCase {

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
    $serverArray = new ServerArray();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $serverArray);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/server_array/json/response');
		$serverAry = new ServerArray();
    $serverAry->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerArray', $serverAry);
		$keys = array_keys($serverAry->getParameters());
		$expectedKeys = array(
	    'actions',
	    'elasticity_params',
	    'server_array[array_type]',
	    'server_array[description]',
	    'instances_count',
	    'server_array[name]',
	    'links',
	    'server_array[state]'
    );		
		foreach($expectedKeys as $prop) {
			$this->assertContains($prop, $keys);
		}
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testHasMultiRunExecutableMethod() {
	  $serverAry = new ServerArray();    
    $this->assertTrue(method_exists($serverAry, 'multi_run_executable'));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testMultiRunExecutableCallsCorrectCommand() {
	  $this->setMockResponse(ClientFactory::getClient('1.5'),
      array(
        '1.5/server_array/json/response',
        '1.5/server_arrays_multi_run_executable/response'
      )
	  );
	  $serverAry = new ServerArray();
	  $serverAry->find_by_id('12345');
	  $serverAry->multi_run_executable('/api/right_scripts/1245');
	  
	  $command = $serverAry->getLastCommand();
	  $request = (string)$command->getRequest();
	  $this->assertContains('/api/server_arrays/12345/multi_run_executable', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testMultiRunExecutableCanIdentifyScriptHref() {
		$this->setMockResponse(ClientFactory::getClient('1.5'),
	    array(
	      '1.5/server_array/json/response',
        '1.5/server_arrays_multi_run_executable/response'
	    )
    );
		$serverAry = new ServerArray();
    $serverAry->find_by_id('12345');
    $serverAry->multi_run_executable('/api/right_scripts/1245');
    
    $command = $serverAry->getLastCommand();
    $request = (string)$command->getRequest();
    $this->assertContains('right_script_href', $request);
    $this->assertNotContains('recipe_name', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testMultiRunExecutableCanIdentifyRecipeName() {
		$this->setMockResponse(ClientFactory::getClient('1.5'),
	    array(
	      '1.5/server_array/json/response',
        '1.5/server_arrays_multi_run_executable/response'
	    )
    );
		$serverAry = new ServerArray();
    $serverAry->find_by_id('12345');
    $serverAry->multi_run_executable('foo::bar');
    
    $command = $serverAry->getLastCommand();
    $request = (string)$command->getRequest();
    $this->assertNotContains('right_script_href', $request);
    $this->assertContains('recipe_name', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testMultiRunExecutableMergesOptions() {
		$this->setMockResponse(ClientFactory::getClient('1.5'),
	    array(
	      '1.5/server_array/json/response',
        '1.5/server_arrays_multi_run_executable/response'
	    )
    );
		$serverAry = new ServerArray();
    $serverAry->find_by_id('12345');
    $options = array(
      'id' => '6',
      'ignore_lock' => 'true',
      'inputs' => array(
        'name' => '/foo/bar/baz',
        'value' => 'text:foobar'
      ),
      'filters' => array(
        'state==operational'
      )
    );
    
    $serverAry->multi_run_executable('foo::bar', $options);
    
    $command = $serverAry->getLastCommand();
    $request = (string)$command->getRequest();
    $this->assertContains('id=6', $request);
    $this->assertContains('ignore_lock=true', $request);
    $this->assertContains('inputs[name]=%2Ffoo%2Fbar%2Fbaz', $request);
    $this->assertContains('inputs[value]=text%3Afoobar', $request);
    $this->assertContains('filters[]=state%3D%3Doperational', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testHasMultiTerminateMethod() {
	  $serverAry = new ServerArray();    
    $this->assertTrue(method_exists($serverAry, 'multi_terminate'));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testMultiTerminateCallsCorrectCommand() {
	  $this->setMockResponse(ClientFactory::getClient('1.5'),
      array(
        '1.5/server_array/json/response',
        '1.5/server_arrays_multi_run_executable/response'
      )
	  );
	  $serverAry = new ServerArray();
	  $serverAry->find_by_id('12345');
	  $serverAry->multi_terminate();
	  
	  $command = $serverAry->getLastCommand();
	  $request = (string)$command->getRequest();
	  $this->assertContains('/api/server_arrays/12345/multi_terminate', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testMultiTerminateMergesOptions() {
		$this->setMockResponse(ClientFactory::getClient('1.5'),
	    array(
	      '1.5/server_array/json/response',
        '1.5/server_arrays_multi_terminate/response'
	    )
    );
		$serverAry = new ServerArray();
    $serverAry->find_by_id('12345');
    $options = array(
      'id' => '6',
      'terminate_all' => 'true',
      'filters' => array(
        'state==operational'
      )
    );
    
    $serverAry->multi_terminate($options);
    
    $command = $serverAry->getLastCommand();
    $request = (string)$command->getRequest();
    $this->assertContains('id=6', $request);
    $this->assertContains('terminate_all=true', $request);
    $this->assertContains('filters[]=state%3D%3Doperational', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testHasLaunchMethod() {
	  $serverAry = new ServerArray();    
    $this->assertTrue(method_exists($serverAry, 'launch'));
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testLaunchCallsCorrectCommand() {
	  $this->setMockResponse(ClientFactory::getClient('1.5'),
      array(
        '1.5/server_array/json/response',
        '1.5/server_arrays_launch/response'
      )
	  );
	  $serverAry = new ServerArray();
	  $serverAry->find_by_id('12345');
	  $serverAry->launch();
	  
	  $command = $serverAry->getLastCommand();
	  $request = (string)$command->getRequest();
	  $this->assertContains('/api/server_arrays/12345/launch', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testLaunchMergesOptions() {
		$this->setMockResponse(ClientFactory::getClient('1.5'),
	    array(
	      '1.5/server_array/json/response',
        '1.5/server_arrays_launch/response'
	    )
    );
		$serverAry = new ServerArray();
    $serverAry->find_by_id('12345');
    $inputs = array(
      'name' => '/foo/bar/baz',
      'value' => 'text:foobar'
    );
    
    $serverAry->launch($inputs);
    
    $command = $serverAry->getLastCommand();
    $request = (string)$command->getRequest();
    $this->assertContains('inputs[name]=%2Ffoo%2Fbar%2Fbaz', $request);
    $this->assertContains('inputs[value]=text%3Afoobar', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetAlertSpecRelationship() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server_array/json/response',
  			'1.5/alert_specs/json/response'
			)
  	);
  	$serverAry = new ServerArray();
  	$serverAry->find_by_id('12345');
  	$alert_specs = $serverAry->alert_specs();
  	$this->assertGreaterThan(0, count($alert_specs));
  	$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\AlertSpec', $alert_specs[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetNextInstanceRelationship() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server_array/json/response',
  			'1.5/instance/json/response'
			)
  	);
  	$serverAry = new ServerArray();
  	$serverAry->find_by_id('12345');
  	$next_instance = $serverAry->next_instance();
  	$this->assertNotNull($next_instance);
  	$this->assertInstanceOf('stdClass', $next_instance);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetCurrentInstancesRelationship() {
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server_array/json/response',
  			'1.5/instances/json/response'
			)
  	);
  	$serverAry = new ServerArray();
  	$serverAry->find_by_id('12345');
  	$current_instances = $serverAry->current_instances();
  	$this->assertInternalType('array', $current_instances);
  	$this->assertGreaterThan(0, $current_instances);
  	$this->assertInstanceOf('stdClass', $current_instances[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetDeploymentRelationship() {
  	$this->markTestSkipped('Deployment command(s) not yet implemented');
  	$this->setMockResponse(
  		ClientFactory::getClient('1.5'),
  		array(
  			'1.5/server_array/json/response',
  			'1.5/deployment/json/response'
			)
  	);
  	$serverAry = new ServerArray();
  	$serverAry->find_by_id('12345');
  	$deployment = $serverAry->deployment();
  	$this->assertNotNull($deployment);
  	$this->assertInstanceOf('stdClass', $deployment);
  }
  
}