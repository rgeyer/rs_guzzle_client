<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class CloudCommandsTest extends \Guzzle\Tests\GuzzleTestCase {
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanListCloudsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/clouds/json/response'
      )
    );

    $command = $client->getCommand('clouds', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanListCloudsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/clouds/xml/response'
      )
    );

    $command = $client->getCommand('clouds', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds.xml', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowCloudJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/cloud/json/response'
      )
    );

    $command = $client->getCommand('cloud', array('id' => '12345', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds/12345.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowCloudXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/cloud/xml/response'
      )
    );

    $command = $client->getCommand('cloud', array('id' => '12345', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds/12345.xml', $request);
	}
}