<?php
namespace RGeyer\Guzzle\Rs\Test\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class AlertSpecCommandsTest extends ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs');
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
        '1.5/alert_specs/json/response'
      )
    );

    $command = $client->getCommand('alert_specs');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs');
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
        '1.5/alert_specs/json/response'
      )
    );

    $command = $client->getCommand('alert_specs');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/alert_specs.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs/json/response'
      )
    );

    $command = $client->getCommand('alert_specs', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/alert_specs.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs/xml/response'
      )
    );

    $command = $client->getCommand('alert_specs', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/alert_specs.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs');
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
    $command = $client->getCommand('alert_specs');
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
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs/json/response'
      )
    );

    $command = $client->getCommand('alert_specs');
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\AlertSpec', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {        
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_spec');
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
        '1.5/alert_spec/json/response'
      )
    );

    $command = $client->getCommand('alert_spec',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_spec');
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
        '1.5/alert_spec/json/response'
      )
    );

    $command = $client->getCommand('alert_spec');
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
        '1.5/alert_spec/json/response'
      )
    );

    $command = $client->getCommand('alert_spec',array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/alert_specs/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_spec/json/response'
      )
    );

    $command = $client->getCommand('alert_spec', array('id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/alert_specs/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_spec/xml/response'
      )
    );

    $command = $client->getCommand(
      'alert_spec',
      array(
        'id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/alert_specs/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_spec');
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
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_spec/json/response'
      )
    );

    $command = $client->getCommand('alert_spec',array('id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\AlertSpec', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs_create');
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
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => '1',
        'alert_spec[file]' => 'file',
        'alert_spec[name]' => 'foo',
        'alert_spec[threshold]' => '1',
        'alert_spec[variable]' => 'var'
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
    $command = $client->getCommand('alert_specs_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[condition] argument be supplied.
   */
  public function testCreateRequiresCondition() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[duration]' => '1',
        'alert_spec[file]' => 'file',
        'alert_spec[name]' => 'foo',
        'alert_spec[threshold]' => '1',
        'alert_spec[variable]' => 'var'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[duration] argument be supplied.
   */
  public function testCreateRequiresDuration() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[file]' => 'file',
        'alert_spec[name]' => 'foo',
        'alert_spec[threshold]' => '1',
        'alert_spec[variable]' => 'var'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[file] argument be supplied.
   */
  public function testCreateRequiresFile() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => '1',
        'alert_spec[name]' => 'foo',
        'alert_spec[threshold]' => '1',
        'alert_spec[variable]' => 'var'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => '1',
        'alert_spec[file]' => 'file',
        'alert_spec[threshold]' => '1',
        'alert_spec[variable]' => 'var'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[threshold] argument be supplied.
   */
  public function testCreateRequiresThreshold() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => '1',
        'alert_spec[file]' => 'file',
        'alert_spec[name]' => 'foo',
        'alert_spec[variable]' => 'var'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage alert_spec[variable] argument be supplied.
   */
  public function testCreateRequiresVariable() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => '1',
        'alert_spec[file]' => 'file',
        'alert_spec[name]' => 'foo',
        'alert_spec[threshold]' => '1'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/alert_specs_create/response'
      )
    );

    $command = $client->getCommand(
      'alert_specs_create',
      array(
        'alert_spec[condition]' => '==',
        'alert_spec[duration]' => '1',
        'alert_spec[file]' => 'file',
        'alert_spec[name]' => 'foo',
        'alert_spec[threshold]' => '1',
        'alert_spec[variable]' => 'var'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\AlertSpec', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {        
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs_update');
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
        '1.5/alert_specs_update/response'
      )
    );

    $command = $client->getCommand('alert_specs_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs_update');
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
        '1.5/alert_specs_update/response'
      )
    );

    $command = $client->getCommand('alert_specs_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs_destroy');
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
        '1.5/alert_specs_destroy/response'
      )
    );

    $command = $client->getCommand('alert_specs_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('alert_specs_destroy');
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
        '1.5/alert_specs_destroy/response'
      )
    );

    $command = $client->getCommand('alert_specs_destroy');
    $command->execute();
  }
  
}