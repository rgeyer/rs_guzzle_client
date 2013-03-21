<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class InstanceTypeCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance_types');
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
        '1.5/instance_types/json/response'
      )
    );

    $command = $client->getCommand('instance_types', array('cloud_id' => '12345'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance_types');
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
        '1.5/instance_types/json/response'
      )
    );

    $command = $client->getCommand('instance_types');
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
        '1.5/instance_types/json/response'
      )
    );

    $command = $client->getCommand('instance_types', array('cloud_id' => 'abc'));
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
        '1.5/instance_types/json/response'
      )
    );

    $command = $client->getCommand('instance_types', array('cloud_id' => '12345'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/instance_types.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance_types/json/response'
      )
    );

    $command = $client->getCommand('instance_types', array('cloud_id' => '12345', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/instance_types.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance_types/xml/response'
      )
    );

    $command = $client->getCommand('instance_types', array('cloud_id' => '12345', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/instance_types.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance_types');
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
    $command = $client->getCommand('instance_types');
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
        '1.5/instance_types/json/response'
      )
    );

    $command = $client->getCommand('instance_types', array('cloud_id' => 12345));
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\InstanceType', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {
//    $this->executeCommand1_5('instance_type', array('cloud_id' => '1', 'id' => '6U7NRRI3I0UM'));
//    $this->executeCommand1_5('instance_type', array('cloud_id' => '1', 'id' => '6U7NRRI3I0UM', 'output_format' => '.xml'));

    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance_type');
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
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('cloud_id' => '12345', 'id' => 'abc123'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instance_type');
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
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('id' => 'abc123'));
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
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('id' => 'abc123', 'cloud_id' => 'abc'));
    $command->execute();
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
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('cloud_id' => '12345'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be of type string
   */
  public function testShowRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand(
      'instance_type',
      array(
        'id' => 12345,
        'cloud_id' => '12345'
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
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('cloud_id' => '12345', 'id' => 'abc123'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\InstanceType', $result);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('cloud_id' => '12345', 'id' => 'abc123'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/instance_types/abc123.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance_type/json/response'
      )
    );

    $command = $client->getCommand('instance_type', array('cloud_id' => '12345', 'id' => 'abc123', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/instance_types/abc123.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instance_type/xml/response'
      )
    );

    $command = $client->getCommand('instance_type', array('cloud_id' => '12345', 'id' => 'abc123', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/instance_types/abc123.xml', $request);
	}
}