<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class CredentialCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credentials');
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
        '1.0/credentials/js/response'
      )
    );

    $command = $client->getCommand('credentials');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credentials');
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
        '1.0/credentials/js/response'
      )
    );

    $command = $client->getCommand('credentials');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/credentials.js', $request);
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
        '1.0/credentials/js/response'
      )
    );

    $command = $client->getCommand('credentials', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/credentials.js', $request);
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
        '1.0/credentials/xml/response'
      )
    );

    $command = $client->getCommand('credentials', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/credentials.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credential');
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
        '1.0/credential/js/response'
      )
    );

    $command = $client->getCommand('credential', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credential');
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
        '1.0/credential/js/response'
      )
    );

    $command = $client->getCommand('credential');
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
        '1.0/credential/js/response'
      )
    );

    $command = $client->getCommand('credential', array('id' => 'abc'));
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
        '1.0/credential/js/response'
      )
    );

    $command = $client->getCommand('credential', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/credentials/1234.js', $request);
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
        '1.0/credential/js/response'
      )
    );

    $command = $client->getCommand('credential', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/credentials/1234.js', $request);
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
        '1.0/credential/xml/response'
      )
    );

    $command = $client->getCommand('credential', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/credentials/1234.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credentials_destroy');
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
        '1.0/credentials_destroy/response'
      )
    );

    $command = $client->getCommand('credentials_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credentials_destroy');
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
        '1.0/credentials_destroy/response'
      )
    );

    $command = $client->getCommand('credentials_destroy');
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
        '1.0/credentials_destroy/response'
      )
    );

    $command = $client->getCommand('credentials_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('alert_specs_create');
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
        '1.0/credentials_create/response'
      )
    );

    $command = $client->getCommand('credentials_create',
      array(
        'credential[name]' => 'name',
        'credential[value]' => 'value'
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
    $command = $client->getCommand('credentials_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage credential[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/credentials_create/response'
      )
    );

    $command = $client->getCommand('credentials_create',
      array(
        'credential[value]' => 'value'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage credential[value] argument be supplied.
   */
  public function testCreateRequiresValue() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/credentials_create/response'
      )
    );

    $command = $client->getCommand('credentials_create',
      array(
        'credential[name]' => 'name'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credentials_update');
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
        '1.0/credentials_update/response'
      )
    );

    $command = $client->getCommand('credentials_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('credentials_update');
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
        '1.0/credentials_update/response'
      )
    );

    $command = $client->getCommand('credentials_update');
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
        '1.0/credentials_update/response'
      )
    );

    $command = $client->getCommand('credentials_update', array('id' => 'abc'));
    $command->execute();
  }
	
//	protected static $testTs;
//	protected static $_credential_href;
//
//	public static function setUpBeforeClass() {
//		self::$testTs = time();
//		$testClassToApproximateThis = new CredentialCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$command = null;
//		$result = $testClassToApproximateThis->executeCommand('credentials_create',
//			array(
//				'credential[name]' => 'GUZZLE_TEST_CRED_' . self::$testTs,
//				'credential[value]' => 'val'
//			),
//			$command
//		);
//
//		self::$_credential_href = $command->getResponse()->getHeader('Location');
//	}
//
//	public static function tearDownAfterClass() {
//		$testClassToApproximateThis = new CredentialCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$cred_id = $testClassToApproximateThis->getIdFromHref('credentials', self::$_credential_href);
//
//		$testClassToApproximateThis->executeCommand('credentials_destroy', array('id' => $cred_id));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanCreateCredential() {
//		$command = null;
//		$result = $this->executeCommand('credentials_create',
//			array(
//				'credential[name]' => 'GUZZLE_TEST_CRED_' . $this->_testTs,
//				'credential[value]' => 'val',
//				'credential[description]' => 'described'
//			),
//			$command
//		);
//
//		$this->assertEquals(201, $command->getResponse()->getStatusCode());
//		$this->assertNotNull($command->getResponse()->getHeader('Location'));
//
//		$regex = ',https://.+/api/acct/[0-9]+/credentials/([0-9]+),';
//		$matches = array();
//		preg_match($regex, $command->getResponse()->getHeader('Location'), $matches);
//
//		$cred_id = $matches[1];
//
//		return $cred_id;
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 * @depends testCanCreateCredential
//	 */
//	public function testCanDestroyCredential($cred_id) {
//		$command = null;
//		$result = $this->executeCommand('credentials_destroy', array('id' => $cred_id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListCredentialsJson() {
//		$command = null;
//		$result = $this->executeCommand('credentials', array(), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertGreaterThan(0, count($json_obj));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListCredentialsXml() {
//		$command = null;
//		$result = $this->executeCommand('credentials', array('output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertGreaterThan(0, count($result->credential));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowCredentialJson() {
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertEquals('GUZZLE_TEST_CRED_' . self::$testTs, $json_obj->name);
//		$this->assertEquals('val', $json_obj->value);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowCredentialXml() {
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href), 'output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertEquals('GUZZLE_TEST_CRED_' . self::$testTs, $result->name);
//		$this->assertEquals('val', $result->value);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanUpdateCredentialName() {
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotEquals('NameChanged', $json_obj->name);
//
//		$command = null;
//		$result = $this->executeCommand('credentials_update',
//			array(
//				'id' => $this->getIdFromHref('credentials', self::$_credential_href),
//				'credential[name]' => 'NameChanged'
//			),
//			$command
//		);
//		$this->assertEquals(204, $command->getResponse()->getStatusCode());
//
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertEquals('NameChanged', $json_obj->name);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanUpdateCredentialValue() {
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotEquals('ValChanged', $json_obj->value);
//
//		$command = null;
//		$result = $this->executeCommand('credentials_update',
//			array(
//				'id' => $this->getIdFromHref('credentials', self::$_credential_href),
//				'credential[value]' => 'ValueChanged'
//			),
//			$command
//		);
//		$this->assertEquals(204, $command->getResponse()->getStatusCode());
//
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertEquals('ValueChanged', $json_obj->value);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanUpdateCredentialDescription() {
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotEquals('DescriptionChanged', $json_obj->description);
//
//		$command = null;
//		$result = $this->executeCommand('credentials_update',
//			array(
//				'id' => $this->getIdFromHref('credentials', self::$_credential_href),
//				'credential[description]' => 'DescriptionChanged'
//			),
//			$command
//		);
//		$this->assertEquals(204, $command->getResponse()->getStatusCode());
//
//		$command = null;
//		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertEquals('DescriptionChanged', $json_obj->description);
//	}
}