<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class ServerArrayCommandsLongRunningTest extends \RGeyer\Guzzle\Rs\Tests\Utils\RightScaleClientTestBase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasIndexCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays');
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
        '1.0/server_arrays/js/response'
      )
    );

    $command = $client->getCommand('server_arrays');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testIndexCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays');
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
        '1.0/server_arrays/js/response'
      )
    );

    $command = $client->getCommand('server_arrays');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays.js', $request);
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
        '1.0/server_arrays/js/response'
      )
    );

    $command = $client->getCommand('server_arrays', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays.js', $request);
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
        '1.0/server_arrays/xml/response'
      )
    );

    $command = $client->getCommand('server_arrays', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasCreateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_create');
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
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[array_type]' => 'alert',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
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
    $command = $client->getCommand('server_arrays_create');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[nickname] argument be supplied.
   */
  public function testCreateRequiresNickname() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[array_type]' => 'alert',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[deployment_href] argument be supplied.
   */
  public function testCreateRequiresDeploymentHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[array_type]' => 'alert',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[array_type] argument be supplied.
   */
  public function testCreateRequiresArrayType() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[ec2_security_groups_href] argument be supplied.
   */
  public function testCreateRequiresSecurityGroupHrefs() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[array_type]' => 'alert',
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[server_template_href] argument be supplied.
   */
  public function testCreateRequiresServerTemplateHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[array_type]' => 'alert',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[ec2_ssh_key_href] argument be supplied.
   */
  public function testCreateRequiresSshKeyHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[array_type]' => 'alert',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345'
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
        '1.0/server_arrays_create/response'
      )
    );

    $command = $client->getCommand('server_arrays_create',
      array(
        'server_array[nickname]' => 'name',
        'server_array[deployment_href]' => 'https://my.rightscale.com/api/acct/12345/deployments/12345',
        'server_array[array_type]' => 'alert',
        'server_array[ec2_security_groups_href]' => array(
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12345',
          'https://my.rightscale.com/api/acct/12345/ec2_security_groups/12346'
        ),
        'server_array[server_template_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'server_array[ec2_ssh_key_href]' => 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345'
      )
    );
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\ServerArray', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasDestroyCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_destroy');
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
        '1.0/server_arrays_destroy/response'
      )
    );

    $command = $client->getCommand('server_arrays_destroy',array('id' => 1234));
    $command->execute();

    $this->assertEquals('DELETE', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testDestroyCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_destroy');
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
        '1.0/server_arrays_destroy/response'
      )
    );

    $command = $client->getCommand('server_arrays_destroy');
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
        '1.0/server_arrays_destroy/response'
      )
    );

    $command = $client->getCommand('server_arrays_destroy', array('id' => 'abc'));
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasShowCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_array');
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
        '1.0/server_array/js/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testShowCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_array');
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
        '1.0/server_array/js/response'
      )
    );

    $command = $client->getCommand('server_array');
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
        '1.0/server_array/js/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => 'abc'));
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
        '1.0/server_array/js/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays/1234.js', $request);
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
        '1.0/server_array/js/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays/1234.js', $request);
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
        '1.0/server_array/xml/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays/1234.xml', $request);
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
        '1.0/server_array/js/response'
      )
    );

    $command = $client->getCommand('server_array', array('id' => '12345'));
    $command->execute();
    $result = $command->getResult();

    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Ec2\ServerArray', $result);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasUpdateCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_update');
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
        '1.0/server_arrays_update/response'
      )
    );

    $command = $client->getCommand('server_arrays_update',array('id' => 1234));
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testUpdateCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_update');
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
        '1.0/server_arrays_update/response'
      )
    );

    $command = $client->getCommand('server_arrays_update');
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
        '1.0/server_arrays_update/response'
      )
    );

    $command = $client->getCommand('server_arrays_update',
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
  public function testHasTerminateAllCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_terminate_all');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTerminateAllUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_terminate_all/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_terminate_all',
      array(
        'id' => 1234
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTerminateAllCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_terminate_all');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testTerminateAllRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_terminate_all/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_terminate_all');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testTerminateAllRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_terminate_all/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_terminate_all',
      array(
        'id' => 'abc',
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasLaunchCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_launch');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testLaunchUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_launch/response'
      )
    );

    $command = $client->getCommand('server_arrays_launch',
      array(
        'id' => 1234
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testLaunchCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_launch');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testLaunchRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_launch/response'
      )
    );

    $command = $client->getCommand('server_arrays_launch');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testLaunchRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_launch/response'
      )
    );

    $command = $client->getCommand('server_arrays_launch',
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
  public function testHasInstancesCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_instances');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testInstancesUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_instances/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_instances', array('id' => 1234));
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testInstancesCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_instances');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testInstancesDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_instances/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_instances', array('id' => 1234));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays/1234/instances.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRequestInstancesAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_instances/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_instances', array('id' => 1234, 'output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays/1234/instances.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRequestInstancesAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_instances/xml/response'
      )
    );

    $command = $client->getCommand('server_arrays_instances', array('id' => 1234, 'output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/server_arrays/1234/instances.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testInstancesRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_instances/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_instances');
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testInstancesRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/server_arrays_instances/js/response'
      )
    );

    $command = $client->getCommand('server_arrays_instances',
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
  public function testHasRunScriptOnAllInstancesCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_run_script_on_all');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunScriptOnAllInstancesUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/login'
      )
    );

    $command = $client->getCommand('server_arrays_run_script_on_all',
      array(
        'id' => 1234,
        'server_array[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();

    $this->assertEquals('POST', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testRunScriptOnAllInstancesCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('server_arrays_run_script_on_all');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage  id argument be supplied.
   */
  public function testRunScriptOnAllInstancesRequiresId() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/login'
      )
    );

    $command = $client->getCommand('server_arrays_run_script_on_all',
      array(
        'server_array[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage id: Value must be numeric
   */
  public function testRunScriptOnAllInstancesRequiresIdToBeAnInt() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/login'
      )
    );

    $command = $client->getCommand('server_arrays_run_script_on_all',
      array(
        'id' => 'abc',
        'server_array[right_script_href]' => 'https://my.rightscale.com/api/acct/12345/right_scripts/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage server_array[right_script_href] argument be supplied.
   */
  public function testRunScriptOnAllInstancesRequiresScriptHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/login'
      )
    );

    $command = $client->getCommand('server_arrays_run_script_on_all',
      array(
        'id' => 1234
      )
    );
    $command->execute();
  }
}