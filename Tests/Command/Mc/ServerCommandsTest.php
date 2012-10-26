<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers');
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
        '1.5/servers/json/response'
      )
    );

    $command = $client->getCommand('servers');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers');
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
        '1.5/servers/json/response'
      )
    );

    $command = $client->getCommand('servers');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers/json/response'
      )
    );

    $command = $client->getCommand('servers', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers/xml/response'
      )
    );

    $command = $client->getCommand('servers', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers');
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
    $command = $client->getCommand('servers');
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
        '1.5/servers/json/response'
      )
    );

    $command = $client->getCommand('servers');
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Server', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_create');
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
        '1.5/servers_create/response'
      )
    );

    $command = $client->getCommand(
      'servers_create',
      array(
        'server[name]' => 'foo',
        'server[deployment_href]' => '/api/deployments/1234',
        'server[instance][cloud_href]' => '/api/clouds/1234',
        'server[instance][server_template_href]' =>'/api/server_templates/1234'
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
    $command = $client->getCommand('servers_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_create/response'
      )
    );

    $command = $client->getCommand(
      'servers_create',
      array(
        'server[deployment_href]' => '/api/deployments/1234',
        'server[instance][cloud_href]' => '/api/clouds/1234',
        'server[instance][server_template_href]' =>'/api/server_templates/1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[deployment_href] argument be supplied.
   */
  public function testCreateRequiresDeploymentHref() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_create/response'
      )
    );

    $command = $client->getCommand(
      'servers_create',
      array(
        'server[name]' => 'name',
        'server[instance][cloud_href]' => '/api/clouds/1234',
        'server[instance][server_template_href]' =>'/api/server_templates/1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[instance][cloud_href] argument be supplied.
   */
  public function testCreateRequiresCloudHref() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_create/response'
      )
    );

    $command = $client->getCommand(
      'servers_create',
      array(
        'server[name]' => 'name',
        'server[deployment_href]' => '/api/deployments/1234',
        'server[instance][server_template_href]' =>'/api/server_templates/1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[instance][server_template_href] argument be supplied.
   */
  public function testCreateRequiresServerTemplateHref() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_create/response'
      )
    );

    $command = $client->getCommand(
      'servers_create',
      array(
        'server[name]' => 'name',
        'server[deployment_href]' => '/api/deployments/1234',
        'server[instance][cloud_href]' => '/api/clouds/1234'
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
        '1.5/servers_create/response'
      )
    );

    $command = $client->getCommand(
      'servers_create',
      array(
        'server[name]' => 'foo',
        'server[deployment_href]' => '/api/deployments/1234',
        'server[instance][cloud_href]' => '/api/clouds/1234',
        'server[instance][server_template_href]' =>'/api/server_templates/1234'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Server', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server');
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
        '1.5/server/json/response'
      )
    );

    $command = $client->getCommand('server',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server');
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
        '1.5/server/json/response'
      )
    );

    $command = $client->getCommand('server');
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
        '1.5/server/json/response'
      )
    );

    $command = $client->getCommand('server',array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server/json/response'
      )
    );

    $command = $client->getCommand('server', array('id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server/xml/response'
      )
    );

    $command = $client->getCommand(
      'server',
      array(
        'id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server');
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
        '1.5/server/json/response'
      )
    );

    $command = $client->getCommand('server',array('id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Server', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_destroy');
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
        '1.5/servers_destroy/response'
      )
    );

    $command = $client->getCommand('servers_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_destroy');
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
        '1.5/servers_destroy/response'
      )
    );

    $command = $client->getCommand('servers_destroy');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasLaunchCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_launch');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testLaunchUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_launch/response'
      )
    );

    $command = $client->getCommand('servers_launch',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testLaunchCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_launch');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testLaunchRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_launch/response'
      )
    );

    $command = $client->getCommand('servers_launch');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasTerminateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_terminate');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testTerminateUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_terminate/response'
      )
    );

    $command = $client->getCommand('servers_terminate',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testTerminateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_terminate');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testTerminateRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/servers_terminate/response'
      )
    );

    $command = $client->getCommand('servers_terminate');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_update');
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
        '1.5/servers_update/response'
      )
    );

    $command = $client->getCommand('servers_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('servers_update');
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
        '1.5/servers_update/response'
      )
    );

    $command = $client->getCommand('servers_update');
    $command->execute();
  }
}