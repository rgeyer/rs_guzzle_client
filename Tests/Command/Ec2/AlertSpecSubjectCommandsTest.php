<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class AlertSpecSubjectCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_spec_subjects_create');
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
        '1.0/alert_spec_subjects_create/response'
      )
    );

    $command = $client->getCommand('alert_spec_subjects_create',
      array(
        'alert_spec_subject[alert_spec_href]' => 'name',
        'alert_spec_subject[subject_href]' => 'file',
        'alert_spec_subject[subject_type]' => 'Server'
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
    $command = $client->getCommand('alert_spec_subjects_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec_subject[alert_spec_href] argument be supplied.
   */
  public function testCreateRequiresAlertSpecHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_spec_subjects_create/response'
      )
    );

    $command = $client->getCommand('alert_spec_subjects_create',
      array(
        'alert_spec_subject[subject_href]' => 'file',
        'alert_spec_subject[subject_type]' => 'Server'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec_subject[subject_href] argument be supplied.
   */
  public function testCreateRequiresSubjectHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_spec_subjects_create/response'
      )
    );

    $command = $client->getCommand('alert_spec_subjects_create',
      array(
        'alert_spec_subject[alert_spec_href]' => 'name',
        'alert_spec_subject[subject_type]' => 'Server'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec_subject[subject_type] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_spec_subjects_create/response'
      )
    );

    $command = $client->getCommand('alert_spec_subjects_create',
      array(
        'alert_spec_subject[alert_spec_href]' => 'name',
        'alert_spec_subject[subject_href]' => 'file'
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
  }

}