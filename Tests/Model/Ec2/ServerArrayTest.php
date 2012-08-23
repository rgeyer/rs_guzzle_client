<?php
namespace RGeyer\Guzzle\Rs\Test\Model\Ec2;

use RGeyer\Guzzle\Rs\Model\ServerArray;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerArrayTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/login');
		ClientFactory::getClient()->get('login')->send();
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanCreateArray() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/server_arrays_create/response');
		$array = new ServerArray();
		$array->create(array(
			'server_array[nickname]' => 'foo',
			'server_array[deployment_href]' => 'bar',
			'server_array[array_type]' => 'alert',
			'server_array[ec2_security_groups_href]' => array('foo'),
			'server_array[server_template_href]' => 'st',
			'server_array[ec2_ssh_key_href]' => 'key'
		));
		$this->assertEquals(12345, $array->id);		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanDestroyArray() {
		$this->setMockResponse(ClientFactory::getClient(),
			array(
				'1.0/server_array/js/response',
				'1.0/server_arrays_destroy/response'
			)
		);
		$array = new ServerArray();
		$array->find_by_id(12345);
		$result = $array->destroy();
		$this->assertEquals(200, $result->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanListAllArrays() {		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/server_arrays/js/response');
		$array = new ServerArray();
		$arrays = $array->index();
		$this->assertGreaterThan(0, count($arrays));
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ServerArray', $arrays[0]);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanListInstances() {
		$this->setMockResponse(ClientFactory::getClient(),
			array(
				'1.0/server_array/js/response',
				'1.0/server_arrays_instances/js/response'
			)
		);
		$array = new ServerArray();
		$array->find_by_id(12345);
		$instances = $array->instances();
		$this->assertTrue(is_array($instances));		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanLaunchAnInstance() {
		$this->setMockResponse(ClientFactory::getClient(),
			array(
				'1.0/server_array/js/response',
				'1.0/server_arrays_launch/response'
			)
		);
		$array = new ServerArray();
		$array->find_by_id(12345);
		$result = $array->launch();
		$this->assertEquals(201, $result->getStatusCode());
		$this->assertNotNull($result->getHeader('Location'));		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRunScriptOnAll() {
		$this->markTestSkipped("No mock response for this command");
		$this->setMockResponse(ClientFactory::getClient(),
				array(
						'1.0/server_array/js/response',
						'1.0/server_arrays_run_script_on_all/response'
				)
		);
		$array = new ServerArray();
		$array->find_by_id(12345);
		$result = $array->run_script_on_all('script_href', array('param1' => 'text:foo'));
		$this->assertEquals(200, $result->getStatusCode());
		$this->assertNotNull($result->getHeader('Location'));
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanFindOneArrayById() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/server_array/js/response'));
		$array = new ServerArray();
		$array->find_by_id(12345);
		$this->assertEquals(12345, $array->id);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanTerminateAll() {
		$this->setMockResponse(ClientFactory::getClient(),
			array(
				'1.0/server_array/js/response',
				'1.0/server_arrays_terminate_all/js/response'
			)
		);
		$array = new ServerArray();
		$array->find_by_id(12345);
		$result = $array->terminate_all();
		$this->objectHasAttribute('success');
		$this->objectHasAttribute('failure');
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanUpdate() {
		$this->markTestSkipped("No mock response for this command because update requests return 422");
		$this->setMockResponse(ClientFactory::getClient(),
				array(
						'1.0/server_array/js/response',
						'1.0/server_arrays_update/js/response'
				)
		);
	}
}