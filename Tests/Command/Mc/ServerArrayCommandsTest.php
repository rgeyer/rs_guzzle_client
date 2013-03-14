<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerArrayCommandsTest extends \RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase {

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasIndexCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays');
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
        '1.5/server_arrays/json/response'
      )
    );

    $command = $client->getCommand('server_arrays');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays');
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
        '1.5/server_arrays/json/response'
      )
    );

    $command = $client->getCommand('server_arrays');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays/json/response'
      )
    );

    $command = $client->getCommand('server_arrays', array('output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestIndexAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays/xml/response'
      )
    );

    $command = $client->getCommand('server_arrays', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testIndexAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays');
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
    $command = $client->getCommand('server_arrays');
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
        '1.5/server_arrays/json/response'
      )
    );

    $command = $client->getCommand('server_arrays');
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerArray', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasShowCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_array');
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
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand('server_array',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_array');
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
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand('server_array');
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
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand('server_array',array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => 1234, 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays/1234.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testShowAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_array/xml/response'
      )
    );

    $command = $client->getCommand(
      'server_array',
      array(
        'id' => '1234',
        'output_format' => '.xml'
      )
    );
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays/1234.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testShowAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_array');
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
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand('server_array',array('id' => '1234'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerArray', $result);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testShowRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand(
      'server_array',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_create');
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
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
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
    $command = $client->getCommand('server_arrays_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[name] argument be supplied.
   */
  public function testCreateRequiresName() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[array_type] argument be supplied.
   */
  public function testCreateRequiresArrayType() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[state] argument be supplied.
   */
  public function testCreateRequiresState() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[instance][cloud_href] argument be supplied.
   */
  public function testCreateRequiresCloudHref() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[instance][server_template_href] argument be supplied.
   */
  public function testCreateRequiresServerTemplateHref() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[elasticity_params][bounds][max_count] argument be supplied.
   */
  public function testCreateRequiresBoundsMax() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[elasticity_params][bounds][min_count] argument be supplied.
   */
  public function testCreateRequiresBoundsMin() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[elasticity_params][pacing][resize_up_by] argument be supplied.
   */
  public function testCreateRequiresResizeUpBy() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[elasticity_params][pacing][resize_down_by] argument be supplied.
   */
  public function testCreateRequiresResizeDownBy() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[elasticity_params][pacing][resize_calm_time] argument be supplied.
   */
  public function testCreateRequiresResizeCalmTime() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
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
        '1.5/server_arrays_create/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_create',
      array(
        'server_array[array_type]' => 'alert',
        'server_array[name]' => 'GuzzleTest',
        'server_array[state]' => 'disabled',
        'server_array[instance][cloud_href]' => '/api/clouds/1234',
        'server_array[instance][server_template_href]' =>'/api/server_templates/12345',
        'server_array[elasticity_params][bounds][max_count]' => '10',
        'server_array[elasticity_params][bounds][min_count]' => '5',
        'server_array[elasticity_params][pacing][resize_up_by]' => '1',
        'server_array[elasticity_params][pacing][resize_down_by]' => '1',
        'server_array[elasticity_params][pacing][resize_calm_time]' => '1',
        'server_array[elasticity_params][alert_specific_params][decision_threshold]' => '51'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\ServerArray', $result);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasUpdateCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_update');
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
        '1.5/server_arrays_update/response'
      )
    );

    $command = $client->getCommand('server_arrays_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_update');
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
        '1.5/server_arrays_update/response'
      )
    );

    $command = $client->getCommand('server_arrays_update');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testUpdateRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_array/json/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_update',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasCurrentInstancesCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_current_instances');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCurrentInstancesUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_current_instances/json/response'
      )
    );

    $command = $client->getCommand('server_arrays_current_instances', array('id' => '1234'));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testCurrentInstancesCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('instances');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCurrentInstancesDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/instances/json/response'
      )
    );

    $command = $client->getCommand('server_arrays_current_instances', array('id' => '1234'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays/1234/current_instances.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestCurrentInstancesAsJson() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_current_instances/json/response'
      )
    );

    $command = $client->getCommand('server_arrays_current_instances', array('id' => '1234', 'output_format' => '.json'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays/1234/current_instances.json', $request);
	}

	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanRequestCurrentInstancesAsXml() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_current_instances/xml/response'
      )
    );

    $command = $client->getCommand('server_arrays_current_instances', array('id' => '1234', 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/api/server_arrays/1234/current_instances.xml', $request);
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCurrentInstancesAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_current_instances');
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
  public function testCurrentInstancesAcceptsViews() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_current_instances');
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
  public function testCurrentInstancesCommandReturnsArrayOfModel() {
    $this->markTestSkipped("No model yet");
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_current_instances/json/response'
      )
    );

    $command = $client->getCommand('server_arrays_current_instances', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertNotNull($result);
    $this->assertInternalType('array', $result);
    $this->assertGreaterThan(0, count($result));
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\Instance', $result[0]);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testCurrentInstancesRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_current_instances/json/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_current_instances',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_destroy');
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
        '1.5/server_arrays_destroy/response'
      )
    );

    $command = $client->getCommand('server_arrays_destroy',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_destroy');
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
        '1.5/server_arrays_destroy/response'
      )
    );

    $command = $client->getCommand('server_arrays_destroy');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testDestroyRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_destroy/response'
      )
    );

    $command = $client->getCommand(
      'server_arrays_destroy',
      array(
        'id' => 'abc'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasLaunchCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_launch');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testLaunchUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_launch/response'
      )
    );

    $command = $client->getCommand('server_arrays_launch',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testLaunchCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_launch');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testLaunchRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_launch/response'
      )
    );

    $command = $client->getCommand('server_arrays_launch');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testHasMultiRunExecutableCommand() {    
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_multi_run_executable');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiRunExecutableUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_multi_run_executable/response'
      )
    );

    $command = $client->getCommand('server_arrays_multi_run_executable', array('id' => '1234', 'recipe_name' => 'sys_firewall::do_list_rules'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiRunExecutableCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_multi_run_executable');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testMultiRunExecutableRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_multi_run_executable/response'
      )
    );

    $command = $client->getCommand('server_arrays_multi_run_executable');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiRunExecutableAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_multi_run_executable');
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
  public function testHasMultiTerminateCommand() {        
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_multi_terminate');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiTerminateUsesCorrectVerb() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_multi_terminate/response'
      )
    );

    $command = $client->getCommand('server_arrays_multi_terminate',array('id' => '1234'));
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiTerminateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_multi_terminate');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_5
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testMultiTerminateRequiresId() {
    $client = ClientFactory::getClient('1.5');
    $this->setMockResponse($client,
      array(
        '1.5/server_arrays_multi_terminate/response'
      )
    );

    $command = $client->getCommand('server_arrays_multi_terminate');
    $command->execute();
  }

  /**
   * @group v1_5
   * @group unit
   */
  public function testMultiTerminateExecutableAcceptsFilters() {
    $client = ClientFactory::getClient('1.5');
    $command = $client->getCommand('server_arrays_multi_terminate');
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
}