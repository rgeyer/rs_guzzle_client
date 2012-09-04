<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

//use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class EbsVolumeCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes');
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
        '1.0/ec2_ebs_volumes/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes');
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
        '1.0/ec2_ebs_volumes/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_ebs_volumes.js', $request);
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
        '1.0/ec2_ebs_volumes/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_ebs_volumes.js', $request);
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
        '1.0/ec2_ebs_volumes/xml/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_ebs_volumes.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volume');
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
        '1.0/ec2_ebs_volume/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volume');
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
        '1.0/ec2_ebs_volume/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume');
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
        '1.0/ec2_ebs_volume/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume', array('id' => 'abc'));
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
        '1.0/ec2_ebs_volume/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_ebs_volumes/1234.js', $request);
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
        '1.0/ec2_ebs_volume/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_ebs_volumes/1234.js', $request);
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
        '1.0/ec2_ebs_volume/xml/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/ec2_ebs_volumes/1234.xml', $request);
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
        '1.0/ec2_ebs_volume/js/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volume', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Ec2EbsVolume', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes_create');
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
        '1.0/ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_create',
      array(
        'ec2_ebs_volume[nickname]' => 'name',
        'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1b',
        'ec2_ebs_volume[aws_size]' => 10
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
    $command = $client->getCommand('ec2_ebs_volumes_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage ec2_ebs_volume[nickname] argument be supplied.
   */
  public function testCreateRequiresNickname() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_create',
      array(
        'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1b',
        'ec2_ebs_volume[aws_size]' => 10
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage ec2_ebs_volume[ec2_availability_zone] argument be supplied.
   */
  public function testCreateRequiresAvailabilityZone() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_create',
      array(
        'ec2_ebs_volume[nickname]' => 'name',
        'ec2_ebs_volume[aws_size]' => 10
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage ec2_ebs_volume[aws_size] argument be supplied.
   */
  public function testCreateRequiresSize() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_create',
      array(
        'ec2_ebs_volume[nickname]' => 'name',
        'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1b'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage ec2_ebs_volume[aws_size]: Value must be numeric
   */
  public function testCreateRequiresSizeToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_ebs_volumes_create/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_create',
      array(
        'ec2_ebs_volume[nickname]' => 'name',
        'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1b',
        'ec2_ebs_volume[aws_size]' => 'abc'
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
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/ec2_ebs_volume_create/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_create',
      array(
        'ec2_ebs_volume[nickname]' => 'name',
        'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1b',
        'ec2_ebs_volume[aws_size]' => 10
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\Ec2EbsVolume', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes_destroy');
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
        '1.0/ec2_ebs_volumes_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes_destroy');
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
        '1.0/ec2_ebs_volumes_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_destroy');
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
        '1.0/ec2_ebs_volumes_destroy/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes_update');
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
        '1.0/ec2_ebs_volumes_update/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_update',
      array(
        'id' => 1234
      )
    );
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('ec2_ebs_volumes_update');
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
        '1.0/ec2_ebs_volumes_update/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_update');
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
        '1.0/ec2_ebs_volumes_update/response'
      )
    );

    $command = $client->getCommand('ec2_ebs_volumes_update',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }
	
//	protected static $testTs;
//	protected static $_ebsvol_href;
//
//	public static function setUpBeforeClass() {
//		self::$testTs = time();
//		$testClassToApproximateThis = new EbsVolumeCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$command = null;
//		$result = $testClassToApproximateThis->executeCommand('ec2_ebs_volumes_create',
//				array(
//						'ec2_ebs_volume[nickname]' => 'Guzzle_Test_For_EBS_' . self::$testTs,
//						'ec2_ebs_volume[description]' => 'described',
//						'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1a',
//						'ec2_ebs_volume[aws_size]' => 1,
//						'cloud_id' => 1
//				),
//				$command
//		);
//
//		self::$_ebsvol_href = $command->getResponse()->getHeader('Location');
//	}
//
//	public static function tearDownAfterClass() {
//		$testClassToApproximateThis = new EbsVolumeCommandsTest();
//		$testClassToApproximateThis->setUp();
//
//		$ebsvol_id = $testClassToApproximateThis->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href);
//
//		$testClassToApproximateThis->executeCommand('ec2_ebs_volumes_destroy', array('id' => $ebsvol_id));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanCreateEbsVolume() {
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volumes_create',
//			array(
//				'ec2_ebs_volume[nickname]' => 'Guzzle_Test_For_EBS_' . $this->_testTs,
//				'ec2_ebs_volume[description]' => 'described',
//				'ec2_ebs_volume[ec2_availability_zone]' => 'us-east-1a',
//				'ec2_ebs_volume[aws_size]' => 1,
//				'cloud_id' => 1
//			),
//			$command
//		);
//
//		$this->assertEquals(201, $command->getResponse()->getStatusCode());
//		$this->assertNotNull($command->getResponse()->getHeader('Location'));
//
//		$vol_id = $this->getIdFromHref('ec2_ebs_volumes', $command->getResponse()->getHeader('Location'));
//
//		return $vol_id;
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 * @depends testCanCreateEbsVolume
//	 */
//	public function testCanDestroyEbsVolume($vol_id) {
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volumes_destroy', array('id' => $vol_id), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanListEbsVolumesJson() {
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volumes', array(), $command);
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
//	public function testCanListEbsVolumesXml() {
//		$propname = 'ec2-ebs-volume';
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volumes', array('output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertGreaterThan(0, count($result->$propname));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowEbsVolumeJson() {
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertEquals('described', $json_obj->description);
//		$this->assertEquals(1, $json_obj->aws_size);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanShowEbsVolumeXml() {
//		$propname = 'aws-size';
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href), 'output_format' => '.xml'), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$this->assertInstanceOf('SimpleXMLElement', $result);
//		$this->assertEquals('described', $result->description);
//		$this->assertEquals(1, intval($result->$propname));
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanUpdateEbsVolumeNickname() {
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertNotEquals('NewNickname', $json_obj->nickname);
//
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volumes_update',
//			array(
//				'id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href),
//				'ec2_ebs_volume[nickname]' => 'NewNickname'),
//			$command
//		);
//		$this->assertEquals(204, $command->getResponse()->getStatusCode());
//
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertEquals('NewNickname', $json_obj->nickname);
//	}
//
//	/**
//	 * @group v1_0
//	 * @group integration
//	 */
//	public function testCanUpdateEbsVolumeDescription() {
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertNotEquals('NewDescription', $json_obj->description);
//
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volumes_update',
//			array(
//				'id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href),
//				'ec2_ebs_volume[description]' => 'NewDescription'),
//			$command
//		);
//		$this->assertEquals(204, $command->getResponse()->getStatusCode());
//
//		$command = null;
//		$result = $this->executeCommand('ec2_ebs_volume', array('id' => $this->getIdFromHref('ec2_ebs_volumes', self::$_ebsvol_href)), $command);
//		$this->assertEquals(200, $command->getResponse()->getStatusCode());
//		$json_obj = json_decode($result->getBody(true));
//		$this->assertNotNull($json_obj);
//		$this->assertEquals('NewDescription', $json_obj->description);
//	}
}