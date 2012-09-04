<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class MacroCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros');
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
        '1.0/macros/js/response'
      )
    );

    $command = $client->getCommand('macros');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros');
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
        '1.0/macros/js/response'
      )
    );

    $command = $client->getCommand('macros');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/macros.js', $request);
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
        '1.0/macros/js/response'
      )
    );

    $command = $client->getCommand('macros', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/macros.js', $request);
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
        '1.0/macros/xml/response'
      )
    );

    $command = $client->getCommand('macros', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/macros.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macro');
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
        '1.0/macro/js/response'
      )
    );

    $command = $client->getCommand('macro', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macro');
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
        '1.0/macro/js/response'
      )
    );

    $command = $client->getCommand('macro');
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
        '1.0/macro/js/response'
      )
    );

    $command = $client->getCommand('macro', array('id' => 'abc'));
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
        '1.0/macro/js/response'
      )
    );

    $command = $client->getCommand('macro', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/macros/1234.js', $request);
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
        '1.0/macro/js/response'
      )
    );

    $command = $client->getCommand('macro', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/macros/1234.js', $request);
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
        '1.0/macro/xml/response'
      )
    );

    $command = $client->getCommand('macro', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/macros/1234.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros_destroy');
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
        '1.0/macros_destroy/response'
      )
    );

    $command = $client->getCommand('macros_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros_destroy');
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
        '1.0/macros_destroy/response'
      )
    );

    $command = $client->getCommand('macros_destroy');
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
        '1.0/macros_destroy/response'
      )
    );

    $command = $client->getCommand('macros_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros_create');
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
        '1.0/macros_create/response'
      )
    );

    $command = $client->getCommand('macros_create',
      array(
        'macro[source_type]' => 'blank'
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
    $command = $client->getCommand('macros_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage macro[source_type] argument be supplied.
   */
  public function testCreateRequiresSourceType() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/macros_create/response'
      )
    );

    $command = $client->getCommand('macros_create');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros_update');
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
        '1.0/macros_update/response'
      )
    );

    $command = $client->getCommand('macros_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('macros_update');
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
        '1.0/macros_update/response'
      )
    );

    $command = $client->getCommand('macros_update');
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
        '1.0/macros_update/response'
      )
    );

    $command = $client->getCommand('macros_update', array('id' => 'abc'));
    $command->execute();
  }
}