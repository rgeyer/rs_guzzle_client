<?php
namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage;

class MultiCloudImageTest extends ClientCommandsBase {
	
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
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/multi_cloud_image/json/response');
		$mci = new MultiCloudImage();
		$mci->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $mci);
		$keys = array_keys($mci->getParameters());		
		foreach(array('links', 'multi_cloud_image[description]', 'actions', 'multi_cloud_image[name]', 'revision') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseXmlResponse() {
	  $this->markTestSkipped("Can not parse an XML response. In normal use it will never be required to");
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/multi_cloud_image/xml/response');
		$mci = new MultiCloudImage();
		$mci->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $mci);
		$keys = array_keys($mci->getParameters());		
		foreach(array('links', 'multi_cloud_image[description]', 'actions', 'multi_cloud_image[name]', 'revision') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}

	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDuplicateMethod() {
		$mci = new MultiCloudImage();
		$mci->duplicate();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetSettingsRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/multi_cloud_image/json/response',
        '1.5/multi_cloud_image_settings/json/response'
      )
    );
		$mci = new MultiCloudImage();
    $mci->find_by_id(12345);
    $settings = $mci->settings();
    $this->assertGreaterThan(0, count($settings));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImageSetting', $settings[0]);
  }
}