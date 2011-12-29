<?php

namespace Guzzle\Rs\Tests\Model;

use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Common\ClientFactory;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SshKeyTest extends ClientCommandsBase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/login');
		ClientFactory::getClient()->get('login')->send();		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanCreateKeySpecifyingParametersWithProperties() {		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/ec2_ssh_keys_create/response');
		
		$key = new SshKey();
		$key->aws_key_name = 'test';
		$key->create();
		$this->assertEquals(12345, $key->id);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanCreateKeySpecifyingParametersOnCreate() {		
		$this->setMockResponse(ClientFactory::getClient(), '1.0/ec2_ssh_keys_create/response');

		$key = new SshKey();
		$key->create(array('ec2_ssh_key[aws_key_name]' => 'test'));
		$this->assertEquals(12345, $key->id);
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanFindKeyByIdJson() {
		$this->setMockResponse(ClientFactory::getClient(), '1.0/ec2_ssh_key/js/response');
		$key = new SshKey();
		$key->find_by_id(12345);
		
		$key_material = 'obfuscated';
		
		$this->assertEquals(12345, $key->id);
		$this->assertRegExp('/([a-f0-9]{2}:?){20}/', $key->aws_fingerprint);
		$this->assertRegExp('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $key->created_at->format('Y-m-d H:i:s'));
		$this->assertRegExp('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $key->updated_at->format('Y-m-d H:i:s'));
		$this->assertEquals('https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345', $key->href);
		$this->assertEquals($key_material, $key->aws_material);		
	}
	
	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanDestroyAKey() {
		$this->setMockResponse(ClientFactory::getClient(), array('1.0/ec2_ssh_key/js/response', '1.0/ec2_ssh_keys_destroy/response'));
		$key = new SshKey();
		$key->find_by_id(12345);
		$result = $key->destroy();
		
		$this->assertEquals(200, $result->getStatusCode());
	}
}

?>