<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerTemplateCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates');
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
        '1.5/login',
        '1.5/server_templates/json/response'
      )
    );

    $command = $client->getCommand('server_templates');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testIndexDefaultsOutputTypeToJson() {
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
    $this->assertContains('/api/server_templates.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
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
    $this->assertContains('/api/server_templates.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates/xml/response'
      )
    );

    $command = $client->getCommand('server_templates', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_templates.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates');
    $args = $command->getApiCommand()->getParams();
    $filter_param = array_filter(
      $args,
      function($arg) {
        return $arg->getName() == 'filter';
      }
    );

    $this->assertNotNull($filter_param);
    $this->assertEquals(1, count($filter_param));
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates');
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
  public function testHasShowCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_template');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_template/json/response'
      )
    );

    $command = $client->getCommand('server_template',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_template');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testShowRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_template/json/response'
      )
    );

    $command = $client->getCommand('server_template');
    $command->execute();
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_template/json/response'
      )
    );

    $command = $client->getCommand('server_template',array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_templates/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_template/json/response'
      )
    );

    $command = $client->getCommand('server_template', array('id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_templates/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_template/xml/response'
      )
    );

    $command = $client->getCommand(
      'server_template',
      array(
        'id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_templates/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_template');
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
  public function testShowCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_template/json/response'
      )
    );

    $command = $client->getCommand('server_template',array('id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_destroy');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('server_templates_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_destroy');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testDestroyRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('server_templates_destroy');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_create');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCreateUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_create/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_create',
      array(
        'server_template[name]' => 'foo'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCreateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_template[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_create/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_create'
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {

    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_create/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_create',
      array(
        'server_template[name]' => 'foo'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_update');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_update/response'
      )
    );

    $command = $client->getCommand('server_templates_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testUpdateRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_update/response'
      )
    );

    $command = $client->getCommand('server_templates_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCloneCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_clone');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_clone/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_clone',
      array(
        'id' => '12345',
        'server_template[name]' => 'foo'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_clone');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCloneRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_clone/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_clone',
      array('server_template[name]' => 'Guzzle Cloned')
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_template[name] argument be supplied.
   */
  public function testCloneRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_clone/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_clone',
      array('id' => '12345')
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneCommandReturnsAModel() {

    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_clone/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_clone',
      array(
        'id' => '12345',
        'server_template[name]' => 'foo'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCommitCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_commit');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCommitUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_commit/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_commit',
      array(
        'id' => '12345',
        'commit_head_dependencies' => 'true',
        'commit_message' => 'initial commit',
        'freeze_repositories' => 'true'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCommitCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_commit');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCommitRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_commit/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_commit',
      array(
        'commit_head_dependencies' => 'true',
        'commit_message' => 'initial commit',
        'freeze_repositories' => 'true'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  commit_head_dependencies argument be supplied.
   */
  public function testCommitRequiresCommitHeadRevisions() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_commit/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_commit',
      array(
        'id' => '12345',
        'commit_message' => 'initial commit',
        'freeze_repositories' => 'true'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  commit_message argument be supplied.
   */
  public function testCommitRequiresCommitMessage() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_commit/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_commit',
      array(
        'id' => '12345',
        'commit_head_dependencies' => 'true',
        'freeze_repositories' => 'true'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  freeze_repositories argument be supplied.
   */
  public function testCommitRequiresFreezeRepositories() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_commit/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_commit',
      array(
        'id' => '12345',
        'commit_head_dependencies' => 'true',
        'commit_message' => 'initial commit'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCommitCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_commit/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_commit',
      array(
        'id' => '12345',
        'commit_head_dependencies' => 'true',
        'commit_message' => 'initial commit',
        'freeze_repositories' => 'true'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasPublishCommand() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_publish');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testPublishUsesCorrectVerb() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_publish/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_publish',
      array(
        'id' => '12345',
        'account_group_hrefs' => array(),
        'descriptions[long]' => 'long',
        'descriptions[short]' => 'short'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testPublishCommandExtendsDefaultCommand() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_templates_publish');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testPublishRequiresId() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_publish/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_publish',
      array(
        'account_group_hrefs' => array(),
        'descriptions[long]' => 'long',
        'descriptions[short]' => 'short'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  account_group_hrefs argument be supplied.
   */
  public function testPublishRequiresAccountGroupHrefs() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_publish/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_publish',
      array(
        'id' => '12345',
        'descriptions[long]' => 'long',
        'descriptions[short]' => 'short'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  descriptions[long] argument be supplied.
   */
  public function testPublishRequiresLongDescription() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_publish/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_publish',
      array(
        'id' => '12345',
        'account_group_hrefs' => array(),
        'descriptions[short]' => 'short'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  descriptions[short] argument be supplied.
   */
  public function testPublishRequiresShortDescription() {
    $this->markTestSkipped("Publish throws a 500 even with sane values");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_publish/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_publish',
      array(
        'id' => '12345',
        'account_group_hrefs' => array(),
        'descriptions[long]' => 'long'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testPublishCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/server_templates_publish/response'
      )
    );

    $command = $client->getCommand(
      'server_templates_publish',
      array(
        'id' => '12345',
        'account_group_hrefs' => array(),
        'descriptions[long]' => 'long',
        'descriptions[short]' => 'short'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Publication', $result);
  }
}