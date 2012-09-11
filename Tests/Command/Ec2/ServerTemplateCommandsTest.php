<?php

namespace RGeyer\Guzzle\Rs\Test\Command;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerTemplateCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\RightScaleClientTestBase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates');
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
        '1.0/ec2_server_templates/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates');
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
        '1.0/ec2_server_templates/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates.js', $request);
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
        '1.0/ec2_server_templates/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates.js', $request);
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
        '1.0/ec2_server_templates/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_template');
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
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_template');
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
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template');
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
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 'abc'));
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
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234.js', $request);
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
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234.js', $request);
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
        '1.0/ec2_server_template/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234.xml', $request);
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
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_template', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\ServerTemplate', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_create');
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
        '1.0/ec2_server_templates_create/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_create',
      array(
        'server_template[nickname]' => 'nickname'
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
    $command = $client->getCommand('ec2_server_templates_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_template[nickname] argument be supplied.
   */
  public function testCreateRequiresNickname() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_create/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_create');
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
        '1.0/ec2_server_templates_create/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_create',
      array(
        'server_template[nickname]' => 'nickname'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\ServerTemplate', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_destroy');
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
        '1.0/ec2_server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_destroy');
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
        '1.0/ec2_server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_destroy');
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
        '1.0/ec2_server_templates_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_update');
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
        '1.0/ec2_server_templates_update/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_update');
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
        '1.0/ec2_server_templates_update/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_update');
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
        '1.0/ec2_server_templates_update/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_update',
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
  public function testHasExecutablesCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_executables');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testExecutablesUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables',array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testExecutablesCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_executables');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testExecutablesDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_template/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/executables.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testExecutablesAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/executables.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testExecutablesAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/executables.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testExecutablesRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testExecutablesRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_server_templates_executables/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_executables', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasAlertSpecsCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_alert_specs');
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
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs',array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testAlertSpecsCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_server_templates_alert_specs');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
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
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/alert_specs.js', $request);
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
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/alert_specs.js', $request);
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
        '1.0/ec2_server_templates_alert_specs/xml/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_server_templates/1234/alert_specs.xml', $request);
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
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs');
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
        '1.0/ec2_server_templates_alert_specs/js/response'
      )
    );

    $command = $client->getCommand('ec2_server_templates_alert_specs', array('id' => 'abc'));
    $command->execute();
  }
	
//	/**
//	 * @var MultiCloudImage
//	 */
//	protected static $_mci;
//
//	protected static $testTs;
//
//	protected static $_st_href;
//
//	public static function setUpBeforeClass() {
//		self::$testTs = time();
//		$mci = new MultiCloudImage();
//		$list = $mci->index();
//
//		self::$_mci = $list[0];
//		$testClassToApproximateThis = new ServerTemplateCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$command = null;
//		$result = $testClassToApproximateThis->executeCommand('ec2_server_templates_create',
//			array(
//					'server_template[nickname]' => 'Guzzle_Test_' . self::$testTs,
//					'server_template[description]' => 'described',
//					'server_template[multi_cloud_image_href]' => self::$_mci->href
//			),
//			$command
//		);
//
//		self::$_st_href = $command->getResponse()->getHeader('Location');
//	}
//
//	public static function tearDownAfterClass() {
//		$testClassToApproximateThis = new ServerTemplateCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$st_id = $testClassToApproximateThis->getIdFromHref('ec2_server_templates', self::$_st_href);
//		$testClassToApproximateThis->executeCommand('ec2_server_templates_destroy', array('id' => $st_id));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanCreateServerTemplate() {
//		$command = null;
//		$result = $this->executeCommand('ec2_server_templates_create',
//			array(
//				'server_template[nickname]' => 'Guzzle_Test_' . $this->_testTs,
//				'server_template[multi_cloud_image_href]' => self::$_mci->href
//			),
//			$command
//		);
//
//		$this->assertEquals(201, $command->getResponse()->getStatusCode());
//		$this->assertNotNull($command->getResponse()->getHeader('Location'));
//
//		$id = $this->getIdFromHref('ec2_server_templates', $command->getResponse()->getHeader('Location'));
//
//		return $id;
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 * @depends testCanCreateServerTemplate
//	 */
//	public function testCanDestroyServerTemplate($id) {
//		$command = null;
//		$result = $this->executeCommand('ec2_server_templates_destroy', array('id' => $id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListServerTemplatesJson() {
//		$command = null;
//		$result = $this->executeCommand('ec2_server_templates', array(), $command);
//
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertGreaterThan(0, count($json_obj));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListServerTemplatesXml() {
//		$command = null;
//		$prop = 'ec2-server-template';
//		$result = $this->executeCommand('ec2_server_templates', array('output_format' => '.xml'), $command);
//
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertGreaterThan(0, count($result->$prop));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowServerTemplateJson() {
//		$command = null;
//		$result = $this->executeCommand('ec2_server_template', array('id' => $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertEquals($this->_serverTemplate->href, $json_obj->href);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowServerTemplateXml() {
//		$command = null;
//		$result = $this->executeCommand('ec2_server_template', array('id' => $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href), 'output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertEquals($this->_serverTemplate->href, $result->href);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListExecutablesJson() {
//		$command = null;
//		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
//		$result = $this->executeCommand('ec2_server_templates_executables', array('id' => $id, 'phase' => 'boot'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertGreaterThan(0, count($json_obj));
//		$this->assertEquals('boot', $json_obj[0]->apply);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListExecutablesXml() {
//		$command = null;
//		$prop = 'server-template-executable';
//		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
//		$result = $this->executeCommand('ec2_server_templates_executables', array('id' => $id, 'phase' => 'boot', 'output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertGreaterThan(0, count($result));
//		$result_prop = $result->$prop;
//		$this->assertEquals('boot', $result_prop[0]->apply);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListAlertSpecsJson() {
//		$command = null;
//		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
//		$result = $this->executeCommand('ec2_server_templates_alert_specs', array('id' => $id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertGreaterThan(0, count($json_obj));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListAlertSpecsXml() {
//		$command = null;
//		$id = $this->getIdFromHref('ec2_server_templates', $this->_serverTemplate->href);
//		$result = $this->executeCommand('ec2_server_templates_alert_specs', array('id' => $id, 'output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertGreaterThan(0, count($result));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanUpdateServerTemplate() {
//		$command = null;
//
//		$st_id = $this->getIdFromHref('ec2_server_templates', self::$_st_href);
//
//		$result = $this->executeCommand('ec2_server_template', array('id' => $st_id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotEquals('described too', $json_obj->description);
//
//		$command = null;
//		$result = $this->executeCommand('ec2_server_templates_update',
//				array(
//						'id' => $st_id,
//						'server_template[description]' => 'described too'
//				),
//				$command
//		);
//		$this->assertEquals(204, $command->getResponse()->getStatusCode());
//
//		$command = null;
//		$result = $this->executeCommand('ec2_server_template', array('id' => $st_id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertEquals('described too', $json_obj->description);
//	}
}

?>