<?php
namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use Guzzle\Tests\GuzzleTestCase;

use RGeyer\Guzzle\Rs\Model\Mc\SshKey;
use RGeyer\Guzzle\Rs\Model\Mc\Cloud;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class SshKeyTest extends GuzzleTestCase {

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
    $key = new SshKey();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $key);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/ssh_key/json/response');
		$key = new SshKey();
    $key->find_by_id('ABC123', array('cloud_id' => '1234'));
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\SshKey', $key);
		$keys = array_keys($key->getParameters());
		$expectedKeys = array(
	    'actions',
	    'resource_uid',
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
   * @expectedExceptionMessage ssh_key does not implement a duplicate method
   */
  public function testSshKeyDoesNotImplementDuplicate() {
    $key = new SshKey();
    $key->duplicate();
  }

}