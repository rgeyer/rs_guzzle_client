<?php

namespace RGeyer\Guzzle\Rs\Tests\Model;

use RGeyer\Guzzle\Rs\Model\ModelBase;
use SimpleXMLElement;
use \DateTime;
use stdClass;

class ModelConcreteClass extends ModelBase {
  public $last_request_params;
  public $last_request_command;

	public function __construct($mixed = null) {
		$this->_path_for_regex = 'ec2_ssh_keys';
		
		$this->_required_params = array('a' => function($mixed, $params) { return new DateTime($mixed); }, 'b' => null, 'c' => null);
		$this->_optional_params = array('d' => null, 'e' => null, 'f' => null);
		parent::__construct($mixed);
	}
	
	public function getId($href) {
		return $this->getIdFromHref($href);
	}

  public function executeCommand($command, array $params = array()) {
    $this->last_request_command = $command;
    $this->last_request_params = $params;
  }
}

/**
 * ModelBase test case.
 */
class ModelBaseTest extends \Guzzle\Tests\GuzzleTestCase {
	
	/**
	 * @var ModelBase
	 */
	private $_modelBase;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		

		$this->_modelBase = new ModelConcreteClass(/* parameters */);
	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		

		$this->_modelBase = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
	}
	
	/**
	 * @group unit
	 */
	public function testCanInstantiateFromSimpleXML() {
		$xmlStr = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<deployment>
  <a type="datetime">2011-01-24T18:14:10Z</a>
  <b>Description</b>
  <c>Nickname</c>
  <href>https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345</href>
<tags type="array"/>
</deployment>
EOF;

		$xml = new SimpleXMLElement($xmlStr);
		$model = new ModelConcreteClass($xml);
		$this->assertInstanceOf('DateTime', $model->a);
		$this->assertEquals('2011-01-24', $model->a->format('Y-m-d'));
		$this->assertInternalType('string', $model->b);
		$this->assertEquals('Description', $model->b);
		$this->assertInternalType('string', $model->c);
		$this->assertEquals('Nickname', $model->c);
	}
	
	/**
	 * @group unit
	 */
	public function testCanInstantiateFromJson() {
		$jsonStr = <<<EOF
{"a":"2011-01-24T18:14:10Z","b":"Description","c":"Nickname","tags":[],"href":"https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345","updated_at":"2011/07/21 21:59:46 +0000","created_at":"2011/01/24 18:14:10 +0000"}		
EOF;

		$json = json_decode($jsonStr);
		$model = new ModelConcreteClass($json);
		$this->assertInstanceOf('DateTime', $model->a);
		$this->assertEquals('2011-01-24', $model->a->format('Y-m-d'));
		$this->assertInternalType('string', $model->b);
		$this->assertEquals('Description', $model->b);
		$this->assertInternalType('string', $model->c);
		$this->assertEquals('Nickname', $model->c);
	}
	
	/**
	 * @group unit
	 */
	public function testCanInstantiateFromStdClass() {
		$stdClass = new stdClass();
		$stdClass->a = "2011-01-24T18:14:10Z";
		$stdClass->b = "Description";
		$stdClass->c = "Nickname";
		$stdClass->tags = array();
		$stdClass->href = "https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345";
		
		$model = new ModelConcreteClass($stdClass);
		$this->assertInstanceOf('DateTime', $model->a);
		$this->assertEquals('2011-01-24', $model->a->format('Y-m-d'));
		$this->assertInternalType('string', $model->b);
		$this->assertEquals('Description', $model->b);
		$this->assertInternalType('string', $model->c);
		$this->assertEquals('Nickname', $model->c);
	}
	
	/**
	 * @group unit
	 */
	public function testGetIdFromHref() {
		$uri = 'https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345';
		
		$this->assertEquals('12345', $this->_modelBase->getId($uri));
	}
	
	/**
	 * @group unit
	 * @expectedException InvalidArgumentException
	 */
	public function testThrowsExceptionWhenRequiredParamsAreMissing() {
		$this->_modelBase->create(array('a' => null));
	}
	
	/**
	 * @group unit
	 * @expectedException InvalidArgumentException
	 */
	public function testThrowsExceptionWhenInvalidParamsAreProvided() {
		$this->_modelBase->create(array('a' => null, 'b' => null, 'c' => null, 'foo' => null));
	}

  /**
   * @group unit
   */
  public function testMergesParamsOnCreate() {
    $a = new DateTime();
    $merged_array = array('a' => $a, 'b' => 'bee', 'c' => 'c');

    $model = new ModelConcreteClass();
    $model->a = $a;
    $model->b = 'b';
    $model->c = 'c';
    $model->create(array('b' => 'bee'));

    $this->assertEquals($merged_array, $model->getParameters());
    $this->assertEquals($merged_array, $model->last_request_params);
  }

  /**
   * @group unit
   */
  public function testMergesParamsOnUpdate() {
    $a = new DateTime();
    $merged_array = array('a' => $a, 'b' => 'bee', 'c' => 'c', 'id' => 1, 'href' => 'href');

    $model = new ModelConcreteClass();
    $model->id = 1;
    $model->href = 'href';
    $model->a = $a;
    $model->b = 'b';
    $model->c = 'c';
    $model->update(array('b' => 'bee'));

    $this->assertEquals($merged_array, $model->getParameters());
    $this->assertEquals($merged_array, $model->last_request_params);
  }

  /**
   * @group unit
   */
  public function testChangesPathOnIndexWhenParentHrefSupplied() {
    $deplHref = '/api/deployments/12345';
    $model = new \RGeyer\Guzzle\Rs\Model\Mc\Server();
    $this->setMockResponse(
      $model->getClient(),
      array(
        '1.5/login',
        '1.5/servers/json/response'
      )
    );
    $model->index($deplHref);
    $commands = $model->getClient()->getLastCommand();
    $command = $commands[0];
    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments/12345/servers', $request);
  }

  /**
   * @group unit
   */
  public function testChangesPathOnIndexWhenParentModelSupplied() {
    $parent = new ModelConcreteClass();
    $parent->href = '/api/servers/12345';
    $model = new \RGeyer\Guzzle\Rs\Model\Mc\Server();
    $this->setMockResponse(
      $model->getClient(),
      array(
        '1.5/login',
        '1.5/servers/json/response'
      )
    );
    $model->index($parent);
    $commands = $model->getClient()->getLastCommand();
    $command = $commands[0];
    $request = (string)$command->getRequest();
    $this->assertContains('/api/servers/12345/servers', $request);
  }

  /**
   * @group unit
   */
  public function testPathOnIndexRetainsOutputFormat() {
    $deplHref = '/api/deployments/12345';
    $model = new \RGeyer\Guzzle\Rs\Model\Mc\Server();
    $this->setMockResponse(
      $model->getClient(),
      array(
        '1.5/login',
        '1.5/servers/json/response'
      )
    );
    $model->index($deplHref);
    $commands = $model->getClient()->getLastCommand();
    $command = $commands[0];
    $request = (string)$command->getRequest();
    $this->assertContains('/api/deployments/12345/servers.json', $request);
  }

  public function testSetsEc2VersionHeaderOnEc2Request() {
    $this->markTestIncomplete('Not yet implemented.');
  }

  public function testSetsMcVersionHeaderOnMcRequest() {
    $this->markTestIncomplete('Not yet implemented.');
  }

  public function testPassesFilters() {
    $this->markTestIncomplete('Not yet implemented.');
  }
}

