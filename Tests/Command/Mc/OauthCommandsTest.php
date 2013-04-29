<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\RightScaleClient;

class OauthCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasOauthCommand() {
    $client = ClientFactory::getClient("1.5");
    $command = $client->getCommand('oauth', array('refresh_token' => 'refresh_token'));
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testOauthUsesCorrectVerb() {
    $client = ClientFactory::getClient("1.5");
    $this->setMockResponse($client,
      array(
        '1.5/oauth/response'
      )
    );

    $command = $client->getCommand('oauth', array('refresh_token' => 'refresh_token'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testOauthExtendsDefaultCommand() {
    $client = ClientFactory::getClient("1.5");
    $command = $client->getCommand('oauth');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage Requires that the refresh_token argument be supplied
   */
  public function testOauthRequiresRefreshToken() {
    $client = ClientFactory::getClient("1.5");
    $this->setMockResponse($client, array('1.5/oauth/response'));

    $command = $client->getCommand('oauth');
    $command->execute();
  }

}