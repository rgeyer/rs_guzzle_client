<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class SecurityGroupRulesCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rules');
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
        '1.5/security_group_rules/json/response'
      )
    );

    $command = $client->getCommand('security_group_rules');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rules');
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
        '1.5/security_group_rules/json/response'
      )
    );

    $command = $client->getCommand('security_group_rules');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/security_group_rules.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rules/json/response'
      )
    );

    $command = $client->getCommand('security_group_rules', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/security_group_rules.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rules/xml/response'
      )
    );

    $command = $client->getCommand('security_group_rules', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/security_group_rules.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rules');
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
    $command = $client->getCommand('security_group_rules');
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
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rules_create');
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
        '1.5/security_group_rules_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'cloud_id' => 1234,
        'security_group_id' => 'abc',
        'security_group_rule[protocol]' => 'tcp',
        'security_group_rule[source_type]' => 'group'
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
    $command = $client->getCommand('security_group_rules_create');
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
        '1.5/security_group_rules_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'security_group_id' => 'abc',
        'security_group_rule[protocol]' => 'tcp',
        'security_group_rule[source_type]' => 'group'
      )
    );
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
        '1.5/security_groups_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'cloud_id' => 'abc',
        'security_group_id' => 'abc',
        'security_group_rule[protocol]' => 'tcp',
        'security_group_rule[source_type]' => 'group'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage security_group_id argument be supplied.
   */
  public function testCreateRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rules_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'cloud_id' => 1234,
        'security_group_rule[protocol]' => 'tcp',
        'security_group_rule[source_type]' => 'group'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage security_group_id: Value must be of type string
   */
  public function testCreateRequiresIdToBeString() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rules_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'cloud_id' => 1234,
        'security_group_id' => 1234,
        'security_group_rule[protocol]' => 'tcp',
        'security_group_rule[source_type]' => 'group'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage security_group_rule[protocol] argument be supplied.
   */
  public function testCreateRequiresProtocol() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rules_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'cloud_id' => 1234,
        'security_group_id' => 'abc',
        'security_group_rule[source_type]' => 'group'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage security_group_rule[source_type] argument be supplied.
   */
  public function testCreateRequiresSourceType() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rules_create/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rules_create',
      array(
        'cloud_id' => 1234,
        'security_group_id' => 'abc',
        'security_group_rule[protocol]' => 'tcp'
      )
    );
    $command->execute();
  }

  /**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanCreateCidrRule() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_groups_create/response'
      )
    );
		$params = array(
      'cloud_id' => 1234,
      'security_group_id' => 'ABC123',
      'security_group_rule[cidr_ips]' => '0.0.0.0/0',
      'security_group_rule[protocol]' => 'tcp',
      'security_group_rule[protocol_details][start_port]' => '25',
      'security_group_rule[protocol_details][end_port]' => '25',
      'security_group_rule[source_type]' => 'cidr_ips'
    );

    $command = $client->getCommand('security_group_rules_create', $params);
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds/1234/security_groups/ABC123/security_group_rules', $request);
    $this->assertContains(urlencode('security_group_rule[cidr_ips]') . '=' . urlencode('0.0.0.0/0'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol]') . '=' . urlencode('tcp'), $request);
    $this->assertContains(urlencode('security_group_rule[source_type]') . '=' . urlencode('cidr_ips'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][start_port]') . '=' . urlencode('25'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][end_port]') . '=' . urlencode('25'), $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanCreateGroupRule() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_groups_create/response'
      )
    );
		$params = array(
      'cloud_id' => 1234,
      'security_group_id' => 'ABC123',
      'security_group_rule[group_owner]' => 'ABC123',
      'security_group_rule[group_name]' => 'foobarbaz',
      'security_group_rule[protocol]' => 'tcp',
      'security_group_rule[protocol_details][start_port]' => '25',
      'security_group_rule[protocol_details][end_port]' => '25',
      'security_group_rule[source_type]' => 'cidr_ips'
    );

    $command = $client->getCommand('security_group_rules_create', $params);
    $command->execute();

    $request = (string)$command->getRequest();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
    $this->assertContains('/api/clouds/1234/security_groups/ABC123/security_group_rules', $request);
    $this->assertContains(urlencode('security_group_rule[group_owner]') . '=' . urlencode('ABC123'), $request);
    $this->assertContains(urlencode('security_group_rule[group_name]') . '=' . urlencode('foobarbaz'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol]') . '=' . urlencode('tcp'), $request);
    $this->assertContains(urlencode('security_group_rule[source_type]') . '=' . urlencode('cidr_ips'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][start_port]') . '=' . urlencode('25'), $request);
    $this->assertContains(urlencode('security_group_rule[protocol_details][end_port]') . '=' . urlencode('25'), $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rule');
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
        '1.5/security_group_rule/json/response'
      )
    );

    $command = $client->getCommand('security_group_rule',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rule');
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
        '1.5/security_group_rule/json/response'
      )
    );

    $command = $client->getCommand('security_group_rule');
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
        '1.5/security_group_rule/json/response'
      )
    );

    $command = $client->getCommand('security_group_rule',array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/security_group_rules/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rule/json/response'
      )
    );

    $command = $client->getCommand('security_group_rule', array('id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/security_group_rules/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/security_group_rule/xml/response'
      )
    );

    $command = $client->getCommand(
      'security_group_rule',
      array(
        'id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/security_group_rules/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rule');
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
        '1.5/security_group_rule/json/response'
      )
    );

    $command = $client->getCommand('security_group_rule',array('id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\SecurityGroupRule', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rules_destroy');
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
        '1.5/security_group_rules_destroy/response'
      )
    );

    $command = $client->getCommand('security_group_rules_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('security_group_rules_destroy');
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
        '1.5/security_group_rules_destroy/response'
      )
    );

    $command = $client->getCommand('security_group_rules_destroy');
    $command->execute();
  }
	
}