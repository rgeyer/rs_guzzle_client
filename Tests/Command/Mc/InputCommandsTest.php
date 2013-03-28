<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class InputCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    #$this->executeCommand1_5('inputs', array('view' => 'inputs_2_0', 'path' => 'clouds/4/instances/6BC291FU4QHIP/inputs.json'));
    #$this->executeCommand1_5('inputs', array('view' => 'inputs_2_0', 'output_format' => '.xml', 'path' => 'clouds/4/instances/6BC291FU4QHIP/inputs.xml'));
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('inputs');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/inputs/json/response'
      )
    );

    $command = $client->getCommand('inputs');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('inputs');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('datacenters');
    $args = $command->getApiCommand()->getParams();
    $filter_param = array_filter(
      $args,
      function($arg) {
        return $arg->getName() == 'view';
      }
    );

    $this->assertNotNull($filter_param);
    $this->assertEquals(1, count($filter_param));
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandReturnsArrayOfModel() {
    $this->markTestSkipped("No model yet");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/inputs/json/response'
      )
    );

    $command = $client->getCommand('inputs');
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Input', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasMultiUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('inputs_multi_update');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiUpdateUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/inputs_multi_update/response'
      )
    );

    $command = $client->getCommand('inputs_multi_update', array('inputs' => array()));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('inputs_multi_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage inputs argument be supplied.
   */
  public function testMultiUpdateRequiresInputs() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/inputs_multi_update/response'
      )
    );

    $command = $client->getCommand('inputs_multi_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage must be of type array
   */
  public function testMultiUpdateRequiresInputsToBeArray() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/inputs_multi_update/response'
      )
    );

    $command = $client->getCommand('inputs_multi_update', array('inputs' => 'foo'));
    $command->execute();
  }
}