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
  public function testExtendsModelBase() {
    $mcis = new MultiCloudImageSetting();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $mcis);
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
	  $this->markTestSkipped("Can not parse an XML response. In normal use it will never be required to");
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

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetMultiCloudImageRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/multi_cloud_image_setting/json/response',
        '1.5/multi_cloud_image/json/response'
      )
    );
		$mciset = new MultiCloudImageSetting();
    $mciset->find_by_id(12345, array('mci_id' => '1234'));
    $mci = $mciset->multi_cloud_image();
    $this->assertNotNull($mci);
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $mci);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetCloudRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/multi_cloud_image_setting/json/response',
        '1.5/cloud/json/response'
      )
    );
		$mciset = new MultiCloudImageSetting();
    $mciset->find_by_id(12345, array('mci_id' => '1234'));
    $cloud = $mciset->cloud();
    $this->assertNotNull($cloud);
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Cloud', $cloud);
  }
	
}
