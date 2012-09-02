<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class AlertSpecCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs');
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
        '1.0/alert_specs/js/response'
      )
    );

    $command = $client->getCommand('alert_specs');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs');
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
        '1.0/alert_specs/js/response'
      )
    );

    $command = $client->getCommand('alert_specs');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/alert_specs.js', $request);
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
        '1.0/alert_specs/js/response'
      )
    );

    $command = $client->getCommand('alert_specs', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/alert_specs.js', $request);
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
        '1.0/alert_specs/xml/response'
      )
    );

    $command = $client->getCommand('alert_specs', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/alert_specs.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_spec');
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
        '1.0/alert_spec/js/response'
      )
    );

    $command = $client->getCommand('alert_spec', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_spec');
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
        '1.0/alert_spec/js/response'
      )
    );

    $command = $client->getCommand('alert_spec');
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
        '1.0/alert_spec/js/response'
      )
    );

    $command = $client->getCommand('alert_spec', array('id' => 'abc'));
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
        '1.0/alert_spec/js/response'
      )
    );

    $command = $client->getCommand('alert_spec', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/alert_specs/1234.js', $request);
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
        '1.0/alert_spec/js/response'
      )
    );

    $command = $client->getCommand('alert_spec', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/alert_specs/1234.js', $request);
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
        '1.0/alert_spec/xml/response'
      )
    );

    $command = $client->getCommand('alert_spec', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/alert_specs/1234.xml', $request);
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
    $command = $client->getCommand('alert_specs_destroy');
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
        '1.0/alert_specs_destroy/response'
      )
    );

    $command = $client->getCommand('alert_specs_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs_destroy');
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
        '1.0/alert_specs_destroy/response'
      )
    );

    $command = $client->getCommand('alert_specs_destroy');
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
        '1.0/alert_specs_destroy/response'
      )
    );

    $command = $client->getCommand('alert_specs_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs_create');
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
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
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
    $command = $client->getCommand('alert_specs_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[file] argument be supplied.
   */
  public function testCreateRequiresFile() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[variable] argument be supplied.
   */
  public function testCreateRequiresVariable() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[condition] argument be supplied.
   */
  public function testCreateRequiresCondition() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[threshold] argument be supplied.
   */
  public function testCreateRequiresThreshold() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[duration] argument be supplied.
   */
  public function testCreateRequiresDuration() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[subject_type] argument be supplied.
   */
  public function testCreateRequiresSubjectType() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_href]' => 'href',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[subject_href] argument be supplied.
   */
  public function testCreateRequiresSubjectHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[action]' => 'escalate'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[action] argument be supplied.
   */
  public function testCreateRequiresAction() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/alert_specs_create/response'
      )
    );

    $command = $client->getCommand('alert_specs_create',
      array(
        'alert_spec[name]' => 'name',
        'alert_spec[file]' => 'file',
        'alert_spec[variable]' => 'variable',
        'alert_spec[condition]' => '==',
        'alert_spec[threshold]' => 'threshold',
        'alert_spec[duration]' => 10,
        'alert_spec[subject_type]' => 'Server',
        'alert_spec[subject_href]' => 'href'
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

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs_update');
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
        '1.0/alert_specs_update/response'
      )
    );

    $command = $client->getCommand('alert_specs_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs_update');
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
        '1.0/alert_specs_update/response'
      )
    );

    $command = $client->getCommand('alert_specs_update');
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
        '1.0/alert_specs_update/response'
      )
    );

    $command = $client->getCommand('alert_specs_update', array('id' => 'abc'));
    $command->execute();
  }
	
}