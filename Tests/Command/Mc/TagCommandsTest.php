<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class TagCommandsTests extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasByResourceCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_by_resource');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByResourceUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_resource/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_resource',
      array(
        'resource_hrefs' => array('/api/servers/1234')
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByResourceCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_by_resource');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage resource_hrefs argument be supplied.
   */
  public function testByResourceRequiresResourceHrefs() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_resource/json/response'
      )
    );

    $command = $client->getCommand('tags_by_resource');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByResourceDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_resource/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_resource',
      array(
        'resource_hrefs' => array('/api/servers/1234')
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/tags/by_resource.json', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByResourceAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_resource/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_resource',
      array(
        'resource_hrefs' => array('/api/servers/1234'),
        'output_format' => '.json'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/tags/by_resource.json', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByResourceAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_resource/xml/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_resource',
      array(
        'resource_hrefs' => array('/api/servers/1234'),
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/tags/by_resource.xml', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasByTagCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_by_tag');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByTagUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_tag/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_tag',
      array(
        'resource_type' => 'instances',
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByTagCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_by_tag');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage resource_type argument be supplied.
   */
  public function testByTagRequiresResourceType() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_tag/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_tag',
      array(
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage tags argument be supplied.
   */
  public function testByTagRequiresTags() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_tag/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_tag',
      array(
        'resource_type' => 'instances'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByTagDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_tag/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_tag',
      array(
        'resource_type' => 'instances',
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/tags/by_tag.json', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByTagAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_tag/json/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_tag',
      array(
        'resource_type' => 'instances',
        'tags' => array('foo:bar=baz'),
        'output_format' => '.json'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/tags/by_tag.json', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testByTagAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_by_tag/xml/response'
      )
    );

    $command = $client->getCommand(
      'tags_by_tag',
      array(
        'resource_type' => 'instances',
        'tags' => array('foo:bar=baz'),
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/tags/by_tag.xml', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasMultiAddCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_multi_add');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiAddUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_multi_add/response'
      )
    );

    $command = $client->getCommand(
      'tags_multi_add',
      array(
        'resource_hrefs' => array('/api/servers/1234'),
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiAddCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_multi_add');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage resource_hrefs argument be supplied.
   */
  public function testMultiAddRequiresResourceHrefs() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_multi_add/response'
      )
    );

    $command = $client->getCommand(
      'tags_multi_add',
      array(
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage tags argument be supplied.
   */
  public function testMultiAddRequiresTags() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_multi_add/response'
      )
    );

    $command = $client->getCommand(
      'tags_multi_add',
      array(
        'resource_hrefs' => array('/api/servers/1234')
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasMultiDeleteCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_multi_delete');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiDeleteUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_multi_delete/response'
      )
    );

    $command = $client->getCommand(
      'tags_multi_delete',
      array(
        'resource_hrefs' => array('/api/servers/1234'),
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiDeleteCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('tags_multi_delete');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage resource_hrefs argument be supplied.
   */
  public function testMultiDeleteRequiresResourceHrefs() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_multi_delete/response'
      )
    );

    $command = $client->getCommand(
      'tags_multi_delete',
      array(
        'tags' => array('foo:bar=baz')
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage tags argument be supplied.
   */
  public function testMultiDeleteRequiresTags() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/tags_multi_delete/response'
      )
    );

    $command = $client->getCommand(
      'tags_multi_delete',
      array(
        'resource_hrefs' => array('/api/servers/1234')
      )
    );
    $command->execute();
  }

}