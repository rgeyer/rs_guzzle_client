<?php

namespace RGeyer\Guzzle\Rs\Test\Command;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerTemplateCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testIndexDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_template');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_template');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testShowRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testShowRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 'abc'));
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testShowDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\ServerTemplate', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_create');
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
        '1.0/ec2_server_templates_create/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_create',
      array(
        'server_template[nickname]' => 'nickname'
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
    $command = $client->getCommand('ec2_server_templates_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_template[nickname] argument be supplied.
   */
  public function testCreateRequiresNickname() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_create/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_create');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_create/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_create',
      array(
        'server_template[nickname]' => 'nickname'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\ServerTemplate', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_destroy');
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
        '1.0/ec2_server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_destroy');
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
        '1.0/ec2_server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_destroy');
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
        '1.0/ec2_server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_update');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_update/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testUpdateRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_update/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_update');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testUpdateRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_update/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_update',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasExecutablesCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_executables');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testExecutablesUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables',array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testExecutablesCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_executables');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testExecutablesDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/executables.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testExecutablesAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/executables.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testExecutablesAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/executables.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testExecutablesRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testExecutablesRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasAlertSpecsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_alert_specs');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testAlertSpecsUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs',array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testAlertSpecsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_alert_specs');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testAlertSpecsDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/alert_specs.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testAlertSpecsAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/alert_specs.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testAlertSpecsAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_alert_specs/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/alert_specs.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testAlertSpecsRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testAlertSpecsRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 'abc'));
    $command->execute();
  }
}

?>