<?php

namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Common\ClientFactory;

class TagCommandsTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasTaggableResourcesCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_taggable_resources');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTaggableResourcesUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_taggable_resources/js/response'
      )
    );

    $command = $client->getCommand('tags_taggable_resources');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTaggableResourcesCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_taggable_resources');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testTaggableResourcesDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_taggable_resources/js/response'
      )
    );

    $command = $client->getCommand('tags_taggable_resources');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/tags/taggable_resources.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRequestTaggableResourcesAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_taggable_resources/js/response'
      )
    );

    $command = $client->getCommand('tags_taggable_resources', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/tags/taggable_resources.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanRequestTaggableResourcesAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_taggable_resources/xml/response'
      )
    );

    $command = $client->getCommand('tags_taggable_resources', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/tags/taggable_resources.xml', $request);
	}

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasTagsSetCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_set');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTagsSetUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_set/response'
      )
    );

    $command = $client->getCommand('tags_set',
      array(
        'resource_href' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'tags' => array('ns:predicate=true')
      )
    );
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTagsSetCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_set');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage resource_href argument be supplied.
   */
  public function testTagsSetRequiresResourceHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_set/response'
      )
    );

    $command = $client->getCommand('tags_set',
      array(
        'tags' => array('ns:predicate=true')
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage tags argument be supplied.
   */
  public function testTagsSetRequiresTags() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_set/response'
      )
    );

    $command = $client->getCommand('tags_set',
      array(
        'resource_href' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasTagsUnsetCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_unset');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTagsUnsetUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_unset/response'
      )
    );

    $command = $client->getCommand('tags_unset',
      array(
        'resource_href' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345',
        'tags' => array('ns:predicate=true')
      )
    );
    $command->execute();

    $this->assertEquals('PUT', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testTagsUnsetCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_unset');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage resource_href argument be supplied.
   */
  public function testTagsUnsetRequiresResourceHref() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_unset/response'
      )
    );

    $command = $client->getCommand('tags_unset',
      array(
        'tags' => array('ns:predicate=true')
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   * @expectedException Guzzle\Service\Exception\ValidationException
   * @expectedExceptionMessage tags argument be supplied.
   */
  public function testTagsUnsetRequiresTags() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_unset/response'
      )
    );

    $command = $client->getCommand('tags_unset',
      array(
        'resource_href' => 'https://my.rightscale.com/api/acct/12345/ec2_server_templates/12345'
      )
    );
    $command->execute();
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testHasSearchCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_search');
    $this->assertNotNull($command);
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testSearchUsesCorrectVerb() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_search/js/response'
      )
    );

    $command = $client->getCommand('tags_search');
    $command->execute();

    $this->assertEquals('GET', $command->getRequest()->getMethod());
  }

  /**
   * @group v1_0
   * @group unit
   */
  public function testSearchCommandExtendsDefaultCommand() {
    $client = ClientFactory::getClient();
    $command = $client->getCommand('tags_search');
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Command\DefaultCommand', $command);
  }

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testSearchDefaultsOutputTypeToJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_search/js/response'
      )
    );

    $command = $client->getCommand('tags_search');
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/tags/search.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanSearchAsJson() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_search/js/response'
      )
    );

    $command = $client->getCommand('tags_search', array('output_format' => '.js'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/tags/search.js', $request);
	}

	/**
	 * @group v1_0
	 * @group unit
	 */
	public function testCanSearchAsXml() {
    $client = ClientFactory::getClient();
    $this->setMockResponse($client,
      array(
        '1.0/login',
        '1.0/tags_search/xml/response'
      )
    );

    $command = $client->getCommand('tags_search', array('output_format' => '.xml'));
    $command->execute();

    $request = (string)$command->getRequest();
    $this->assertContains('/tags/search.xml', $request);
	}
}

?>