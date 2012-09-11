<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerEbsVolumeCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\RightScaleClientTestBase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('component_ec2_ebs_volumes_create');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_create',
      array(
        'component_ec2_ebs_volume[component_href]' => 'https://my.rightscale.com/api/acct/12345/servers/12345',
        'component_ec2_ebs_volume[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345',
        'component_ec2_ebs_volume[device]' => 'sda'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('component_ec2_ebs_volumes_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage component_ec2_ebs_volume[component_href] argument be supplied.
   */
  public function testCreateRequiresComponentHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_create',
      array(
        'component_ec2_ebs_volume[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345',
        'component_ec2_ebs_volume[device]' => 'sda'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage component_ec2_ebs_volume[ec2_ebs_volume_href] argument be supplied.
   */
  public function testCreateRequiresEbsVolumeHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_create',
      array(
        'component_ec2_ebs_volume[component_href]' => 'https://my.rightscale.com/api/acct/12345/servers/12345',
        'component_ec2_ebs_volume[device]' => 'sda'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_create',
      array(
        'component_ec2_ebs_volume[component_href]' => 'https://my.rightscale.com/api/acct/12345/servers/12345',
        'component_ec2_ebs_volume[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345',
        'component_ec2_ebs_volume[device]' => 'sda'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Na', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('component_ec2_ebs_volumes_destroy');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_destroy/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('component_ec2_ebs_volumes_destroy');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testDestroyRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_destroy/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_destroy');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testDestroyRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/component_ec2_ebs_volumes_destroy/response'
      )
    );

    $command = $client->getCommand('component_ec2_ebs_volumes_destroy', array('id' => 'abc'));
    $command->execute();
  }
}