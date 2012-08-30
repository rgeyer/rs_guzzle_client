<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerTemplateCommandsTest extends ClientCommandsBase {

  public function testServerTemplatesIndexCommandExists() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates/json/response'
      )
    );

    $command = $client->getCommand('server_templates');
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/server_templates', $request);
  }

  public function testServerTemplatesIndexCommandCanRequestJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates/json/response'
      )
    );

    $command = $client->getCommand('server_templates', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/server_templates.json', $request);
  }

  public function testServerTemplatesIndexCommandCanRequestXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates/json/response'
      )
    );

    $command = $client->getCommand('server_templates', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
    $this->assertContains('/api/server_templates.xml', $request);
  }
}