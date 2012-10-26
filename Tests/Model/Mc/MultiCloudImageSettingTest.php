<?php
namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImageSetting;

class MultiCloudImageSettingTest extends ClientCommandsBase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/multi_cloud_image_setting/json/response');
		$mciSetting = new MultiCloudImageSetting();
		$mciSetting->find_by_id('12345', array('mci_id' => '1234'));		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImageSetting', $mciSetting);
		$keys = array_keys($mciSetting->getParameters());		
		foreach(array('links', 'actions') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseXmlResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/multi_cloud_image_setting/xml/response');
		$mciSetting = new MultiCloudImageSetting();
		$mciSetting->find_by_id('12345', array('mci_id' => '1234'));		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImageSetting', $mciSetting);
		$keys = array_keys($mciSetting->getParameters());		
		foreach(array('links', 'actions') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDuplicateMethod() {
		$mci = new MultiCloudImageSetting();
		$mci->duplicate();
	}
	
}
