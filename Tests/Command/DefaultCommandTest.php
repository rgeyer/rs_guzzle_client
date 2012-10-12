<?php
namespace RGeyer\Guzzle\Rs\Tests\Command;

use RGeyer\Guzzle\Rs\RightScaleClient;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class DefaultCommandTest extends \Guzzle\Tests\GuzzleTestCase {

	protected function setUp() {
		parent::setUp();

		$this->setMockResponse(ClientFactory::getClient(), '1.0/login');
		ClientFactory::getClient()->get('login')->send();
	}

  public function testSetsVersionHeaderCorrectly() {

  }

  public function testSetsPathPrefixCorrectly() {

  }

  public function testDisposesTheDisposableParameters() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('deployments');
    $command->setDisposableParameters(array('path' => null));
  }

  public function testDisposesOfParametersWithLocationOfPath() {

  }

  public function testGetMethodEncodesValuesProperly() {

  }

  public function testGetMethodEncodesArrayValuesProperly() {

  }

  public function testPostMethodEncodesValuesProperly() {

  }

  public function testPostMethodEncodesArrayValuesProperly() {

  }

  public function testPutMethodEncodesValuesProperly() {

  }

  public function testPutMethodEncodesArrayValuesProperly() {

  }

  public function testPutMethodSetsContentTypeHeader() {

  }

  public function testReturnsModelOnIndexWhenOutputTypeIsXml() {
  	$client = ClientFactory::getClient();
    $this->setMockResponse(
      $client,
      array(
        '1.0/deployments/xml/response'
      )
    );
    $command = $client->getCommand('deployments', array('output_format' => '.xml'));
    $command->execute();
    $result = $command->getResult();
    $this->assertTrue(is_array($result));
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Deployment', $result[0]);
    $this->assertGreaterThan(0, $result[0]->getParameters());
  }

  public function testReturnsModelOnIndexWhenOutputTypeIsJson() {
  	$client = ClientFactory::getClient();
    $this->setMockResponse(
      $client,
      array(
        '1.0/deployments/js/response'
      )
    );
    $command = $client->getCommand('deployments', array('output_format' => '.js'));
    $command->execute();
    $result = $command->getResult();
    $this->assertTrue(is_array($result));
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Deployment', $result[0]);
    $this->assertGreaterThan(0, $result[0]->getParameters());
  }

}
