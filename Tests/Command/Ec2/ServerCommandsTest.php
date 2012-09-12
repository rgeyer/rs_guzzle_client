<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerCommandsLongRunningTest extends \RGeyer\Guzzle\Rs\Tests\Utils\RightScaleClientTestBase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers');
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
        '1.0/servers/js/response'
      )
    );

    $command = $client->getCommand('servers');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers');
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
        '1.0/servers/js/response'
      )
    );

    $command = $client->getCommand('servers');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers.js', $request);
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
        '1.0/servers/js/response'
      )
    );

    $command = $client->getCommand('servers', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers.js', $request);
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
        '1.0/servers/xml/response'
      )
    );

    $command = $client->getCommand('servers', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server');
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
        '1.0/server/js/response'
      )
    );

    $command = $client->getCommand('server', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server');
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
        '1.0/server/js/response'
      )
    );

    $command = $client->getCommand('server');
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
        '1.0/server/js/response'
      )
    );

    $command = $client->getCommand('server', array('id' => 'abc'));
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
        '1.0/server/js/response'
      )
    );

    $command = $client->getCommand('server', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234.js', $request);
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
        '1.0/server/js/response'
      )
    );

    $command = $client->getCommand('server', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234.js', $request);
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
        '1.0/server/xml/response'
      )
    );

    $command = $client->getCommand('server', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234.xml', $request);
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
        '1.0/server/js/response'
      )
    );

    $command = $client->getCommand('server', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_create');
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
        '1.0/servers_create/response'
      )
    );

    $command = $client->getCommand('servers_create',
      array(
        'server[nickname]' => 'name'
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
    $command = $client->getCommand('servers_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[nickname] argument be supplied.
   */
  public function testCreateRequiresNickname() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_create/response'
      )
    );

    $command = $client->getCommand('servers_create');
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
        '1.0/servers_create/response'
      )
    );

    $command = $client->getCommand('servers_create',
      array(
        'server[nickname]' => 'name'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_destroy');
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
        '1.0/servers_destroy/response'
      )
    );

    $command = $client->getCommand('servers_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_destroy');
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
        '1.0/servers_destroy/response'
      )
    );

    $command = $client->getCommand('servers_destroy');
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
        '1.0/servers_destroy/response'
      )
    );

    $command = $client->getCommand('servers_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_update');
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
        '1.0/servers_update/response'
      )
    );

    $command = $client->getCommand('servers_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_update');
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
        '1.0/servers_update/response'
      )
    );

    $command = $client->getCommand('servers_update');
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
        '1.0/servers_update/response'
      )
    );

    $command = $client->getCommand('servers_update',
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
  public function testHasStartCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_start');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStartUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start/response'
      )
    );

    $command = $client->getCommand('servers_start',array('id' => 1234));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStartCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_start');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testStartRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start/response'
      )
    );

    $command = $client->getCommand('servers_start');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testStartRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start/response'
      )
    );

    $command = $client->getCommand('servers_start', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStartCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start/response'
      )
    );

    $command = $client->getCommand('servers_start', array('id' => 1234));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasStartEbsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_start_ebs');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStartEbsUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start_ebs/response'
      )
    );

    $command = $client->getCommand('servers_start_ebs',array('id' => 1234));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStartEbsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_start_ebs');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testStartEbsRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start_ebs/response'
      )
    );

    $command = $client->getCommand('servers_start_ebs');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testStartEbsRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start_ebs/response'
      )
    );

    $command = $client->getCommand('servers_start_ebs', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStartEbsCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_start_ebs/response'
      )
    );

    $command = $client->getCommand('servers_start_ebs', array('id' => 1234));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasStopCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_start');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStopUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop/response'
      )
    );

    $command = $client->getCommand('servers_stop',array('id' => 1234));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStopCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_stop');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testStopRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop/response'
      )
    );

    $command = $client->getCommand('servers_stop');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testStopRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop/response'
      )
    );

    $command = $client->getCommand('servers_stop', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStopCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop/response'
      )
    );

    $command = $client->getCommand('servers_stop', array('id' => 1234));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasStopEbsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_stop_ebs');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStopEbsUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop_ebs/response'
      )
    );

    $command = $client->getCommand('servers_stop_ebs',array('id' => 1234));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStopEbsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_stop_ebs');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testStopEbsRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop_ebs/response'
      )
    );

    $command = $client->getCommand('servers_stop_ebs');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testStopEbsRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop_ebs/response'
      )
    );

    $command = $client->getCommand('servers_stop_ebs', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testStopEbsCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_stop_ebs/response'
      )
    );

    $command = $client->getCommand('servers_stop_ebs', array('id' => 1234));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasRebootCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_reboot');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRebootUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_reboot/response'
      )
    );

    $command = $client->getCommand('servers_reboot',array('id' => 1234));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRebootCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_reboot');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testRebootRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_reboot/response'
      )
    );

    $command = $client->getCommand('servers_reboot');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testRebootRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_reboot/response'
      )
    );

    $command = $client->getCommand('servers_reboot', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRebootCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_reboot/response'
      )
    );

    $command = $client->getCommand('servers_reboot', array('id' => 1234));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasRunScriptCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_run_script');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunScriptUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_script/response'
      )
    );

    $command = $client->getCommand('servers_run_script',
      array(
        'id' => 1234,
        'server[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunScriptCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_run_script');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testRunScriptRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_script/response'
      )
    );

    $command = $client->getCommand('servers_run_script',
      array(
        'server[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testRunScriptRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_script/response'
      )
    );

    $command = $client->getCommand('servers_run_script',
      array(
        'id' => 'abc',
        'server[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunScriptCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_script/response'
      )
    );

    $command = $client->getCommand('servers_run_script',
      array(
        'id' => 1234,
        'server[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasRunExecutableCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_run_executable');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunExecutableUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_executable/response'
      )
    );

    $command = $client->getCommand('servers_run_executable',
      array(
        'id' => 1234
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunExecutableCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_run_executable');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testRunExecutableRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_script/response'
      )
    );

    $command = $client->getCommand('servers_run_executable');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testRunExecutableRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_executable/response'
      )
    );

    $command = $client->getCommand('servers_run_executable',
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
  public function testRunExecutabeCommandReturnsAModel() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_executable/response'
      )
    );

    $command = $client->getCommand('servers_run_executable',
      array(
        'id' => 1234
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Server', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasAttachVolumeCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_attach_volume');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testAttachVolumeUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_attach_volume/response'
      )
    );

    $command = $client->getCommand('servers_attach_volume',
      array(
        'id' => 1234,
        'server[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345',
        'server[device]' => '/dev/sdj'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testAttachVolumeCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_attach_volume');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[device] argument be supplied.
   */
  public function testAttachVolumeRequiresDevice() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_attach_volume/response'
      )
    );

    $command = $client->getCommand('servers_attach_volume',
      array(
        'id' => 1234,
        'server[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server[ec2_ebs_volume_href] argument be supplied.
   */
  public function testAttachVolumeRequiresEbsVolumeHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_attach_volume/response'
      )
    );

    $command = $client->getCommand('servers_attach_volume',
      array(
        'id' => 1234,
        'server[device]' => '/dev/sdj'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testAttachVolumeRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_attach_volume/response'
      )
    );

    $command = $client->getCommand('servers_attach_volume',
      array(
        'server[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345',
        'server[device]' => '/dev/sdj'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testAttachVolumeRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_run_executable/response'
      )
    );

    $command = $client->getCommand('servers_attach_volume',
      array(
        'id' => 'abc',
        'server[ec2_ebs_volume_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ebs_volumes/12345',
        'server[device]' => '/dev/sdj'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasSettingsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_settings');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testSettingsUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_settings', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testSettingsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_settings');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testSettingsRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_settings');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testSettingsRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_settings', array('id' => 'abc'));
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testSettingsDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_settings', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/settings.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetSettingsAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_settings', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/settings.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetSettingsAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_settings/xml/response'
      )
    );

    $command = $client->getCommand('servers_settings', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/settings.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasGetSketchyDataCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_get_sketchy_data');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testGetSketchyDataUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle'
      )
    );
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testGetSketchyDataCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_get_sketchy_data');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage start argument be supplied.
   */
  public function testGetSketchyDataRequiresStart() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage end argument be supplied.
   */
  public function testGetSketchyDataRequiresEnd() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage plugin_name argument be supplied.
   */
  public function testGetSketchyDataRequiresPluginName() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'end' => 10,
        'plugin_type' => 'cpu-idle'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage plugin_type argument be supplied.
   */
  public function testGetSketchyDataRequiresPluginType() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testGetSketchyDataRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle',
        'output_format' => '.xml'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testGetSketchyDataRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 'abc',
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle',
        'output_format' => '.xml'
      )
    );
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetSketcyDataDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/get_sketchy_data.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetSketchyDataAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/js/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle',
        'output_format' => '.js'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/get_sketchy_data.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetSketchyDataAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_get_sketchy_data/xml/response'
      )
    );

    $command = $client->getCommand('servers_get_sketchy_data',
      array(
        'id' => 1234,
        'start' => 1,
        'end' => 10,
        'plugin_name' => 'cpu-0',
        'plugin_type' => 'cpu-idle',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/get_sketchy_data.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCurrentShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_current_show');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCurrentShowUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_show/js/response'
      )
    );

    $command = $client->getCommand('servers_current_show', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCurrentShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_current_show');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCurrentShowRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_show/js/response'
      )
    );

    $command = $client->getCommand('servers_current_show');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testCurrentShowRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_show/js/response'
      )
    );

    $command = $client->getCommand('servers_current_show', array('id' => 'abc'));
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCurrentShowDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_show/js/response'
      )
    );

    $command = $client->getCommand('servers_current_show', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/current.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCurrentShowAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_show/js/response'
      )
    );

    $command = $client->getCommand('servers_current_show', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/current.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCurrentShowAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_show/xml/response'
      )
    );

    $command = $client->getCommand('servers_current_show', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/current.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCurrentUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_current_update');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCurrentUpdateUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_update/response'
      )
    );

    $command = $client->getCommand('servers_current_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCurrentUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_current_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCurrentUpdateRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_update/response'
      )
    );

    $command = $client->getCommand('servers_current_update');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testCurrentUpdateRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_update/response'
      )
    );

    $command = $client->getCommand('servers_current_update',
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
  public function testHasCurrentSettingsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_current_settings');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCurrentSettingsUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_current_settings', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCurrentSettingsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_current_settings');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCurrentSettingsRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_current_settings');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testCurrentSettingsRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_current_settings', array('id' => 'abc'));
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCurrentSettingsDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_current_settings', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/current/settings.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetCurrentSettingsAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_settings/js/response'
      )
    );

    $command = $client->getCommand('servers_current_settings', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/current/settings.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testGetCurrentSettingsAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_current_settings/xml/response'
      )
    );

    $command = $client->getCommand('servers_current_settings', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/current/settings.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasAlertSpecsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_alert_specs');
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
        '1.0/servers_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('servers_alert_specs', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testAlertSpecsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_alert_specs');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
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
        '1.0/servers_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('servers_alert_specs');
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
        '1.0/servers_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('servers_alert_specs', array('id' => 'abc'));
    $command->execute();
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
        '1.0/servers_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('servers_alert_specs', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/alert_specs.js', $request);
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
        '1.0/servers_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('servers_alert_specs', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/alert_specs.js', $request);
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
        '1.0/servers_alert_specs/xml/response'
      )
    );

    $command = $client->getCommand('servers_alert_specs', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/alert_specs.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasMonitoringCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_monitoring');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testMonitoringUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testMonitoringCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_monitoring');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testMonitoringRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testMonitoringRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring', array('id' => 'abc'));
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testMonitoringDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/monitoring.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testMonitoringAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/monitoring.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testMonitoringAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring/xml/response'
      )
    );

    $command = $client->getCommand('servers_monitoring', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/monitoring.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasMonitoringGraphNameCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_monitoring_graph_name');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testMonitoringGraphNameUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'graph_name' => 'graph',
        'size' => 'tiny',
        'period' => 'now'
      )
    );
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testMonitoringGraphNameCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('servers_monitoring_graph_name');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage period argument be supplied.
   */
  public function testMonitoringGraphNameRequiresPeriod() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'graph_name' => 'graph',
        'size' => 'tiny'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage graph_name argument be supplied.
   */
  public function testMonitoringGraphNameRequiresGraphName() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'size' => 'tiny',
        'period' => 'now'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage size argument be supplied.
   */
  public function testMonitoringGraphNameRequiresSize() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'graph_name' => 'graph',
        'period' => 'now'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testMonitoringGraphNameRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'graph_name' => 'graph',
        'size' => 'tiny',
        'period' => 'now'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testMonitoringGraphNameRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => 'abc',
        'graph_name' => 'graph',
        'size' => 'tiny',
        'period' => 'now'
      )
    );
    $command->execute();
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testMonitoringGraphNameDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'graph_name' => 'graph',
        'size' => 'tiny',
        'period' => 'now'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/monitoring/graph.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testMonitoringGraphNameAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/js/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'graph_name' => 'graph',
        'size' => 'tiny',
        'period' => 'now',
        'output_format' => '.js'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/monitoring/graph.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testMonitoringGraphNameAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/servers_monitoring_graph_name/xml/response'
      )
    );

    $command = $client->getCommand('servers_monitoring_graph_name',
      array(
        'id' => '1234',
        'graph_name' => 'graph',
        'size' => 'tiny',
        'period' => 'now',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/servers/1234/monitoring/graph.xml', $request);
	}
}

?>