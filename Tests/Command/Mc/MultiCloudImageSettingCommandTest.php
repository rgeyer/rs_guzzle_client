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
    $command = $client->getCommand('multi_cloud_image_settings');
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
            '1.5/multi_cloud_image_settings/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings', array('mci_id' => '12345'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings');
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
            '1.5/login',
            '1.5/multi_cloud_image_settings/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings', array('mci_id' => '12345'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/12345/settings.json', $request);
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
            '1.5/multi_cloud_image_settings/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings', array('mci_id' => '12345', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/12345/settings.json', $request);
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
            '1.5/multi_cloud_image_settings/xml/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings', array('mci_id' => '12345', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/12345/settings.xml', $request);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings');
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
  public function testHasCreateCommand() {
//     $command = null;
//     $this->executeCommand1_5('multi_cloud_image_settings_create',
//       array(
//         'mci_id' => '270338001',
//         'multi_cloud_image_setting[cloud_href]' => '/api/clouds/1868',
//         'multi_cloud_image_setting[image_href]' => '/api/clouds/1868/images/3SDPA9GENAUVH',
//         'multi_cloud_image_setting[instance_type_href]' => '/api/clouds/1868/instance_types/D5GHRVB1DMVQC'
//       )
//     );
    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings_create');
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
            '1.5/multi_cloud_image_settings_create/response'
        )
    );

    $command = $client->getCommand(
        'multi_cloud_image_settings_create',
        array(
            'mci_id' => '12345'
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
    $command = $client->getCommand('multi_cloud_image_settings_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }



  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage mci_id argument be supplied.
   */
  public function testCreateRequiresMciId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
        array(
            '1.5/login',
            '1.5/multi_cloud_image_settings_create/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_create');
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
            '1.5/multi_cloud_image_settings_create/response'
        )
    );

    $command = $client->getCommand(
      'multi_cloud_image_settings_create',
      array(
        'mci_id' => '1234',
        'multi_cloud_image_setting[name]' => 'foo'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImageSetting', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {
    #$command = null;
    #$this->executeCommand1_5('multi_cloud_image_settings_update', array('mci_id' => '270338001', 'id' => '540094001', 'multi_cloud_image_setting[image_href]' => '/api/clouds/1868/images/3SDPA9GENAUVH',));
    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings_update');
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
            '1.5/login',
            '1.5/multi_cloud_image_settings_update/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_update',array('mci_id' => 1234, 'id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings_update');
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
            '1.5/login',
            '1.5/multi_cloud_image_settings_update/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_update', array('mci_id' => '1234'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage mci_id argument be supplied.
   */
  public function testUpdateRequiresMciId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
        array(
            '1.5/login',
            '1.5/multi_cloud_image_settings_update/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_update', array('id' => '1234'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_setting');
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
            '1.5/multi_cloud_image_setting/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_setting', array('mci_id' => '1234', 'id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_setting');
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
            '1.5/login',
            '1.5/multi_cloud_image_setting/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_setting', array('mci_id' => '1234'));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage mci_id argument be supplied.
   */
  public function testShowRequiresMciId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
        array(
            '1.5/login',
            '1.5/multi_cloud_image_setting/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_setting', array('id' => '1234'));
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
            '1.5/multi_cloud_image_setting/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_setting',array('mci_id' => '1234', 'id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/1234/settings/1234.json', $request);
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
            '1.5/multi_cloud_image_setting/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_setting', array('mci_id' => '1234', 'id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/1234/settings/1234.json', $request);
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
            '1.5/multi_cloud_image_setting/xml/response'
        )
    );

    $command = $client->getCommand(
        'multi_cloud_image_setting',
        array(
          'mci_id' => '1234', 
          'id' => '1234',
          'output_format' => '.xml'
        )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/multi_cloud_images/1234/settings/1234.xml', $request);
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
            '1.5/multi_cloud_image_setting/json/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_setting',array('mci_id' => '1234', 'id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\MultiCloudImageSetting', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings_destroy');
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
            '1.5/multi_cloud_image_settings_destroy/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_destroy',array('mci_id' => '1234', 'id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('multi_cloud_image_settings_destroy');
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
            '1.5/login',
            '1.5/multi_cloud_image_settings_destroy/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_destroy', array('mci_id' => 1234));
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage mci_id argument be supplied.
   */
  public function testDestroyRequiresMciId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
        array(
            '1.5/login',
            '1.5/multi_cloud_image_settings_destroy/response'
        )
    );

    $command = $client->getCommand('multi_cloud_image_settings_destroy', array('id' => 1234));
    $command->execute();
  }
}