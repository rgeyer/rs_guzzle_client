<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ElasticIpCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ips');
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
        '1.0/ec2_elastic_ips/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ips');
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
        '1.0/ec2_elastic_ips/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_elastic_ips.js', $request);
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
        '1.0/ec2_elastic_ips/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_elastic_ips.js', $request);
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
        '1.0/ec2_elastic_ips/xml/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_elastic_ips.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ip');
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
        '1.0/ec2_elastic_ip/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ip');
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
        '1.0/ec2_elastic_ip/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip');
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
        '1.0/ec2_elastic_ip/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip', array('id' => 'abc'));
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
        '1.0/ec2_elastic_ip/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_elastic_ips/1234.js', $request);
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
        '1.0/ec2_elastic_ip/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_elastic_ips/1234.js', $request);
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
        '1.0/ec2_elastic_ip/xml/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_elastic_ips/1234.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_elastic_ip/js/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ip', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Ec2ElasticIp', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ips_create');
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
        '1.0/ec2_elastic_ips_create/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips_create',array('ec2_elastic_ip[nickname]' => 'name'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ips_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage ec2_elastic_ip[nickname] argument be supplied.
   */
  public function testCreateRequiresNickname() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_elastic_ips_create/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips_create');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testCreateCommandReturnsAModel() {
    $this->markTestSkipped("A model does not yet exist");
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_elastic_ips_create/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips_create',
      array(
        'ec2_elastic_ip[nickname]' => 'name'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Ec2ElasticIp', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ips_destroy');
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
        '1.0/ec2_elastic_ips_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_elastic_ips_destroy');
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
        '1.0/ec2_elastic_ips_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips_destroy');
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
        '1.0/ec2_elastic_ips_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_elastic_ips_destroy', array('id' => 'abc'));
    $command->execute();
  }
	
//	protected static $testTs;
//	protected static $_eip_href;
//
//	public static function setUpBeforeClass() {
//		self::$testTs = time();
//		$testClassToApproximateThis = new ElasticIpCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$command = null;
//		$result = $testClassToApproximateThis->executeCommand('ec2_elastic_ips_create',
//			array(
//				'ec2_elastic_ip[nickname]' => 'Guzzle_Test_' . self::$testTs
//			),
//			$command
//		);
//
//		self::$_eip_href = $command->getResponse()->getHeader('Location');
//	}
//
//	public static function tearDownAfterClass() {
//		$testClassToApproximateThis = new ElasticIpCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$eip_id = $testClassToApproximateThis->getIdFromHref('ec2_elastic_ips', self::$_eip_href);
//
//		$testClassToApproximateThis->executeCommand('ec2_elastic_ips_destroy', array('id' => $eip_id));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanCreateElasticIp() {
//		$command = null;
//		$result = $this->executeCommand('ec2_elastic_ips_create',
//			array(
//				'ec2_elastic_ip[nickname]' => 'Guzzle_Test_' . $this->_testTs
//			),
//			$command
//		);
//
//		$this->assertEquals(201, $command->getResponse()->getStatusCode());
//		$this->assertNotNull($command->getResponse()->getHeader('Location'));
//
//		$ip_id = $this->getIdFromHref('ec2_elastic_ips', $command->getResponse()->getHeader('Location'));
//
//		return $ip_id;
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 * @depends testCanCreateElasticIp
//	 */
//	public function testCanDestroyElasticIp($ip_id) {
//		$command = null;
//		$result = $this->executeCommand('ec2_elastic_ips_destroy', array('id' => $ip_id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListElasticIpsJson() {
//		$command = null;
//		$result = $this->executeCommand('ec2_elastic_ips', array(), $command);
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
//	public function testCanListElasticIpsXml() {
//		$propname = 'ec2-elastic-ip';
//		$command = null;
//		$result = $this->executeCommand('ec2_elastic_ips', array('output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertGreaterThan(0, count($result->$propname));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowElasticIpJson() {
//		$command = null;
//		$result = $this->executeCommand('ec2_elastic_ip', array('id' => $this->getIdFromHref('ec2_elastic_ips', self::$_eip_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertEquals('Guzzle_Test_' . self::$testTs, $json_obj->nickname);
//		$this->assertEquals(self::$_eip_href, $json_obj->href);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowElasticIpXml() {
//		$command = null;
//		$result = $this->executeCommand('ec2_elastic_ip', array('id' => $this->getIdFromHref('ec2_elastic_ips', self::$_eip_href), 'output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertEquals('Guzzle_Test_' . self::$testTs, $result->nickname);
//		$this->assertEquals(strval(self::$_eip_href), strval($result->href));
//	}
	
}