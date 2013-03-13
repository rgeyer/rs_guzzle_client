<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class DeploymentCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {

    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments');
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
        '1.5/deployments/json/response'
      )
    );

    $command = $client->getCommand('deployments');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments');
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
        '1.5/deployments/json/response'
      )
    );

    $command = $client->getCommand('deployments');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments/json/response'
      )
    );

    $command = $client->getCommand('deployments', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments/xml/response'
      )
    );

    $command = $client->getCommand('deployments', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments');
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
  public function testIndexCommandReturnsArrayOfModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments/json/response'
      )
    );

    $command = $client->getCommand('deployments');
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Deployment', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployment');
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
        '1.5/deployment/json/response'
      )
    );

    $command = $client->getCommand('deployment', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployment');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id argument be supplied.
   */
  public function testShowRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployment/json/response'
      )
    );

    $command = $client->getCommand('deployment');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testShowRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployment/json/response'
      )
    );

    $command = $client->getCommand(
      'deployment',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployment/json/response'
      )
    );

    $command = $client->getCommand('deployment', array('id' => 12345));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Deployment', $result);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployment/json/response'
      )
    );

    $command = $client->getCommand('deployment', array('id' => '12345'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments/12345.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployment/json/response'
      )
    );

    $command = $client->getCommand('deployment', array('id' => '12345', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments/12345.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployment/xml/response'
      )
    );

    $command = $client->getCommand('deployment', array('id' => '12345', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments/12345.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments_create');
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
        '1.5/deployments_create/response'
      )
    );

    $command = $client->getCommand(
      'deployments_create',
      array(
        'deployment[name]' => 'foo',
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
    $command = $client->getCommand('deployments_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage deployment[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments_create/response'
      )
    );

    $command = $client->getCommand('deployments_create');
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
        '1.5/deployments_create/response'
      )
    );

    $command = $client->getCommand(
      'deployments_create',
      array(
        'deployment[name]' => 'foo',
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Deployment', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments_update');
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
        '1.5/deployments_update/response'
      )
    );

    $command = $client->getCommand(
      'deployments_update',
      array(
        'id' => '12345',
        'deployment[name]' => 'foo',
      )
    );
    $command->execute();
    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id argument be supplied.
   */
  public function testUpdateRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments_update/response'
      )
    );

    $command = $client->getCommand('deployments_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments_update/response'
      )
    );

    $command = $client->getCommand(
      'deployments_update',
      array(
        'id' => '12345',
        'deployment[name]' => 'foo',
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Deployment', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCloneCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments_clone');
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
        '1.5/deployments_clone/response'
      )
    );

    $command = $client->getCommand(
      'deployments_clone',
      array(
        'id' => '12345'
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
    $command = $client->getCommand('deployments_clone');
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
        '1.5/deployments_clone/response'
      )
    );

    $command = $client->getCommand('deployments_clone');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/deployments_clone/response'
      )
    );

    $command = $client->getCommand(
      'deployments_clone',
      array(
        'id' => '12345'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Deployment', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments_destroy');
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
        '1.5/deployments_destroy/response'
      )
    );

    $command = $client->getCommand('deployments_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('deployments_destroy');
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
        '1.5/deployments_destroy/response'
      )
    );

    $command = $client->getCommand('deployments_destroy');
    $command->execute();
  }
}