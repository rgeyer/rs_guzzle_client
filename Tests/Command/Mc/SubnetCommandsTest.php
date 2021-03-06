<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class SubnetCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('subnets');
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
        '1.5/subnets/json/response'
      )
    );

    $command = $client->getCommand('subnets', array('cloud_id' => '12345'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('subnets');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testIndexRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets/json/response'
      )
    );

    $command = $client->getCommand('subnets');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testIndexRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets/json/response'
      )
    );

    $command = $client->getCommand('subnets', array('cloud_id' => 'abc'));
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
        '1.5/subnets/json/response'
      )
    );

    $command = $client->getCommand('subnets', array('cloud_id' => '12345'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/subnets.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets/json/response'
      )
    );

    $command = $client->getCommand('subnets', array('cloud_id' => '12345', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/subnets.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets/xml/response'
      )
    );

    $command = $client->getCommand('subnets', array('cloud_id' => '12345', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/subnets.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('subnets');
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
        '1.5/subnets/json/response'
      )
    );

    $command = $client->getCommand('subnets', array('cloud_id' => 12345));
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Subnet', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {
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
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('cloud_id' => '12345', 'id' => 'abc123'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('subnet');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testShowRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('id' => 'abc123'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testShowRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('id' => 'abc123', 'cloud_id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id argument be supplied.
   */
  public function testShowRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('cloud_id' => '12345'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be of type string
   */
  public function testShowRequiresIdToBeAString() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand(
      'subnet',
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
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('cloud_id' => '12345', 'id' => 'abc123'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Subnet', $result);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('cloud_id' => '12345', 'id' => 'abc123'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/subnets/abc123.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/json/response'
      )
    );

    $command = $client->getCommand('subnet', array('cloud_id' => '12345', 'id' => 'abc123', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/subnets/abc123.json', $request);
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnet/xml/response'
      )
    );

    $command = $client->getCommand('subnet', array('cloud_id' => '12345', 'id' => 'abc123', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/clouds/12345/subnets/abc123.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('subnets_update');
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
        '1.5/subnets_update/response'
      )
    );

    $command = $client->getCommand(
      'subnets_update',
      array(
        'id' => '12345',
        'cloud_id' => '12345',
        'subnet[name]' => 'foo',
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
    $command = $client->getCommand('subnets_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id argument be supplied.
   */
  public function testUpdateRequiresCloudId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets_update/response'
      )
    );

    $command = $client->getCommand('subnets_update', array('id' => 'abc123'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage cloud_id: Value must be numeric
   */
  public function testUpdateRequiresCloudIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets_update/response'
      )
    );

    $command = $client->getCommand('subnets_update', array('id' => 'abc123', 'cloud_id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException \Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id argument be supplied.
   */
  public function testUpdateRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/subnets_update/response'
      )
    );

    $command = $client->getCommand('subnets_update');
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
        '1.5/subnets_update/response'
      )
    );

    $command = $client->getCommand(
      'subnets_update',
      array(
        'id' => '12345',
        'cloud_id' => '12345',
        'subnet[name]' => 'foo',
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Subnet', $result);
  }
}