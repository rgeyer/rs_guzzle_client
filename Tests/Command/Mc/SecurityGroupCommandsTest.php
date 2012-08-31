<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use RGeyer\Guzzle\Rs\Common\ClientFactory;

class SecurityGroupCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_groups');
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
        '1.5/security_groups/json/response'
      )
    );

    $command = $client->getCommand('security_groups', array('cloud_id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_groups');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testIndexRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups/json/response'
      )
    );

    $command = $client->getCommand('security_groups');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testIndexRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups/json/response'
      )
    );

    $command = $client->getCommand('security_groups', array('cloud_id' => 'abc'));
    $command->execute();
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
        '1.5/security_groups/json/response'
      )
    );

    $command = $client->getCommand('security_groups', array('cloud_id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/security_groups.json', $request);
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
        '1.5/security_groups/json/response'
      )
    );

    $command = $client->getCommand('security_groups', array('cloud_id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/security_groups.json', $request);
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
        '1.5/security_groups/xml/response'
      )
    );

    $command = $client->getCommand('security_groups', array('cloud_id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/security_groups.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_groups');
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
    $command = $client->getCommand('security_groups');
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
    $command = $client->getCommand('security_group');
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
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand(
      'security_group',
      array(
        'id' => '1234',
        'cloud_id' => 1234
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
    $command = $client->getCommand('security_group');
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
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand('security_group');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testShowRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand(
      'security_group',
      array(
        'id' => 1234,
        'cloud_id' => 'abc'
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
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand('security_group');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be of type string
   */
  public function testShowRequiresIdToBeAString() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand(
      'security_group',
      array(
        'id' => 1234,
        'cloud_id' => 1234
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
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand(
      'security_group',
      array(
        'id' => '1234',
        'cloud_id' => 1234,
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/security_groups/1234.json', $request);
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
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand('security_group', array('id' => '1234', 'cloud_id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/security_groups/1234.json', $request);
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
        '1.5/security_group/xml/response'
      )
    );

    $command = $client->getCommand(
      'security_group',
      array(
        'id' => '1234',
        'cloud_id' => 1234,
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/1234/security_groups/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group');
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
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand(
      'security_group',
      array(
        'id' => '1234',
        'cloud_id' => 1234,
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\SecurityGroup', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_groups_create');
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
        '1.5/security_groups_create/response'
      )
    );

    $command = $client->getCommand(
      'security_groups_create',
      array(
        'cloud_id' => 1234,
        'security_group[name]' => 'name'
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
    $command = $client->getCommand('security_groups_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**   *
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage security_group[name] argument be supplied
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups_create/response'
      )
    );

    $command = $client->getCommand(
      'security_groups_create',
      array(
        'cloud_id' => 1234
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testCreateRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups_create/response'
      )
    );

    $command = $client->getCommand('security_groups_create');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testCreateRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups_create/response'
      )
    );

    $command = $client->getCommand('security_groups_create', array('cloud_id' => 'abc'));
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
        '1.5/login',
        '1.5/security_groups_create/response'
      )
    );

    $command = $client->getCommand(
      'security_groups_create',
      array(
        'cloud_id' => 1234,
        'security_group[name]' => 'name'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\SecurityGroup', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_groups_destroy');
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
        '1.5/security_groups_destroy/response'
      )
    );

    $command = $client->getCommand(
      'security_groups_destroy',
      array(
        'id' => '1234',
        'cloud_id' => 1234
      )
    );
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_groups_destroy');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testDestroyRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_group/json/response'
      )
    );

    $command = $client->getCommand('security_groups_destroy', array('id' => '1234'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testDestroyRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups_destroy/response'
      )
    );

    $command = $client->getCommand(
      'security_groups_destroy',
      array(
        'id' => 1234,
        'cloud_id' => 'abc'
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
  public function testDestroyRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups_destroy/response'
      )
    );

    $command = $client->getCommand('security_groups_destroy', array('cloud_id' => 1234));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be of type string
   */
  public function testDestroyRequiresIdToBeAString() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/login',
        '1.5/security_groups_destroy/response'
      )
    );

    $command = $client->getCommand(
      'security_groups_destroy',
      array(
        'id' => 1234,
        'cloud_id' => 1234
      )
    );
    $command->execute();
  }
}