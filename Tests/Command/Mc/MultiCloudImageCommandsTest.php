<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class MultiCloudImageCommandsTest extends ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {      
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images');
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
        '1.5/multi_cloud_images/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images');
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
        '1.5/multi_cloud_images/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images/xml/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images');
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
        '1.5/multi_cloud_images/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images');
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_create');
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
        '1.5/multi_cloud_images_create/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_create',
      array(
        'multi_cloud_image[name]' => 'foo'
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
    $command = $client->getCommand('multi_cloud_images_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage multi_cloud_image[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_create/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images_create');
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
        '1.5/multi_cloud_images_create/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_create',
      array(
        'multi_cloud_image[name]' => 'foo'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_update');
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
        '1.5/multi_cloud_images_update/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_update');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
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
        '1.5/multi_cloud_images_update/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCloneCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_clone');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_clone/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_clone',
      array(
        'id' => '12345',
        'multi_cloud_image[name]' => 'foo'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_clone');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCloneRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_clone/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_clone',
      array('multi_cloud_image[name]' => 'Guzzle Cloned')
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage multi_cloud_image[name] argument be supplied.
   */
  public function testCloneRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_clone/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_clone',
      array('id' => '12345')
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCloneCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_clone/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_clone',
      array(
        'id' => '12345',
        'multi_cloud_image[name]' => 'foo'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCommitCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_commit');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCommitUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_commit/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_commit',
      array(
        'id' => '12345',
        'commit_message' => 'initial commit'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCommitCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_commit');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testCommitRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_commit/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_commit',
      array(
        'commit_message' => 'initial commit'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  commit_message argument be supplied.
   */
  public function testCommitRequiresCommitMessage() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_commit/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_commit',
      array(
        'id' => '12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCommitCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_images_commit/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_images_commit',
      array(
        'id' => '12345',
        'commit_message' => 'initial commit'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {   
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image');
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
        '1.5/multi_cloud_image/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_image',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image');
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
        '1.5/multi_cloud_image/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_image');
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
        '1.5/multi_cloud_image/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_image',array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_image/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_image', array('id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_image/xml/response'
      )
    );

    $command = $client->getCommand(
      'multi_cloud_image',
      array(
        'id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandReturnsAModel() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/multi_cloud_image/json/response'
      )
    );

    $command = $client->getCommand('multi_cloud_image',array('id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImage', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_destroy');
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
        '1.5/multi_cloud_images_destroy/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_images_destroy');
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
        '1.5/multi_cloud_images_destroy/response'
      )
    );

    $command = $client->getCommand('multi_cloud_images_destroy');
    $command->execute();
  } 
}