<?php
namespace RGeyer\Guzzle\Rs\Tests\Command;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class DefaultCommandTest extends \PHPUnit_Framework_TestCase {

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

}