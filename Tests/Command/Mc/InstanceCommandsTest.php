<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class InstanceCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances');
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
        '1.5/instances/json/response'
      )
    );

    $command = $client->getCommand('instances', array('cloud_id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances');
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
        '1.5/instances/json/response'
      )
    );

    $command = $client->getCommand('instances', array('cloud_id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/instances.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances/json/response'
      )
    );

    $command = $client->getCommand('instances', array('cloud_id' => '1234', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/instances.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances/xml/response'
      )
    );

    $command = $client->getCommand('instances', array('cloud_id' => '1234', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/instances.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances');
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
    $command = $client->getCommand('instances');
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
    $command = $client->getCommand('instance');
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
        '1.5/instance/json/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'id' => '1234',
        'cloud_id' => '1234'
      )
    );
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testShowRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance/json/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'id' => '1234'
      )
    );
    $command->execute();
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
        '1.5/instance/json/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'cloud_id' => '1234'
      )
    );
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
        '1.5/instance/json/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'id' => '1234',
        'cloud_id' => '1234'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/instances/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance/json/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'id' => '1234',
        'cloud_id' => '1234',
        'output_format' => '.json'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/instances/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance/xml/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'id' => '1234',
        'cloud_id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/instances/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance');
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
        '1.5/instance/json/response'
      )
    );

    $command = $client->getCommand('instance',
      array(
        'id' => '1234',
        'cloud_id' => '1234'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Instance', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_update');
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
        '1.5/instances_update/response'
      )
    );

    $command = $client->getCommand('instances_update',array('id' => 'abc', 'cloud_id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testUpdateRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_update/response'
      )
    );

    $command = $client->getCommand('instances_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testUpdateRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_update/response'
      )
    );

    $command = $client->getCommand('instances_update', array('id' => 'abc', 'cloud_id' => 'abc'));
    $command->execute();
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
        '1.5/instances_update/response'
      )
    );

    $command = $client->getCommand('instances_update',array('cloud_id' => 1234));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasLaunchCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_launch');
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
        '1.5/instances_launch/response'
      )
    );

    $command = $client->getCommand('instances_launch',array('id' => '1234', 'cloud_id' => 1234));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testLaunchCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_launch');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testLaunchRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_launch/response'
      )
    );

    $command = $client->getCommand('instances_launch', array('id' => 'abc', 'cloud_id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasMultiRunExecutableCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_multi_run_executable');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiRunExecutableUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_multi_run_executable/response'
      )
    );

    $command = $client->getCommand('instances_multi_run_executable', array('cloud_id' => 1234, 'recipe_name' => 'sys_firewall::do_list_rules'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiRunExecutableCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_multi_run_executable');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiRunExecutableAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_multi_run_executable');
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
  public function testHasMultiTerminateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_multi_terminate');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiTerminateUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_multi_terminate/response'
      )
    );

    $command = $client->getCommand('instances_multi_terminate',array('cloud_id' => '1234', 'terminate_all' => 'true'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiTerminateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_multi_terminate');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiTerminateExecutableAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_multi_terminate');
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
  public function testHasRebootCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_reboot');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testRebootUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_reboot/response'
      )
    );

    $command = $client->getCommand('instances_reboot',array('cloud_id' => '1234', 'id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testRebootRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_reboot/response'
      )
    );

    $command = $client->getCommand('instances_reboot',
      array(
        'id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testRebootRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_reboot/response'
      )
    );

    $command = $client->getCommand('instances_reboot',
      array(
        'cloud_id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testRebootCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_reboot');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasRunExecutableCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_run_executable');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testRunExecutableUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_run_executable/response'
      )
    );

    $command = $client->getCommand('instances_run_executable',
      array(
        'cloud_id' => 1234,
        'id' => 'ABC123',
        'recipe_name' => 'sys_firewall::do_list_rules'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testRunExecutableCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_run_executable');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testRunExecutableRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_run_executable/response'
      )
    );

    $command = $client->getCommand('instances_run_executable',
      array(
        'id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testRunExecutableRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_run_executable/response'
      )
    );

    $command = $client->getCommand('instances_run_executable',
      array(
        'cloud_id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasStartCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_start');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testStartUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_start/response'
      )
    );

    $command = $client->getCommand('instances_start',array('cloud_id' => '1234', 'id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testStartCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_start');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testStartRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_start/response'
      )
    );

    $command = $client->getCommand('instances_start',
      array(
        'id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testStartRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_start/response'
      )
    );

    $command = $client->getCommand('instances_start',
      array(
        'cloud_id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasStopCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_stop');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testStopUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_stop/response'
      )
    );

    $command = $client->getCommand('instances_stop',array('cloud_id' => '1234', 'id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testStopCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_stop');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testStopRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_stop/response'
      )
    );

    $command = $client->getCommand('instances_stop',
      array(
        'id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testStopRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances_stop/response'
      )
    );

    $command = $client->getCommand('instances_stop',
      array(
        'cloud_id' => '1234'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasTerminateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_terminate');
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
        '1.5/instances_terminate/response'
      )
    );

    $command = $client->getCommand('instances_terminate',array('cloud_id' => '1234', 'id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testTerminateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances_terminate');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }
}