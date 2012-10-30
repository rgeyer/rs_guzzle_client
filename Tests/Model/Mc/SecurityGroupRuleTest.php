<?php
namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Common\ClientFactory;
use RGeyer\Guzzle\Rs\Model\Mc\SecurityGroupRule;

class SecurityGroupRuleTest extends \Guzzle\Tests\GuzzleTestCase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/login');
		ClientFactory::getClient('1.5')->get('session')->send();
	}
  
  /**
   * @group v1_5
   * @group unit
   */
  public function testExtendsModelBase() {
    $sgr = new SecurityGroupRule();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\ModelBase', $sgr);
  }
	
	/**
	 * @group v1_5
	 * @group unit
	 */
	public function testCanParseJsonResponse() {
		$this->setMockResponse(ClientFactory::getClient('1.5'), '1.5/security_group_rule/json/response');
		$secgrpr = new SecurityGroupRule();
		$secgrpr->find_by_id('12345');		
		$this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\SecurityGroupRule', $secgrpr);
		$keys = array_keys($secgrpr->getParameters());		
		foreach(array('links', 'security_group_rule[protocol]', 'actions', 'href', 'id') as $prop) {
			$this->assertContains($prop, $keys);
		}
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportDuplicateMethod() {
		$secgrprule = new SecurityGroupRule();
		$secgrprule->duplicate();
	}
	
	/**
	 * @group v1_5
	 * @group unit
	 * @expectedException BadMethodCallException
	 */
	public function testDoesNotSupportUpdateMethod() {
		$secgrprule = new SecurityGroupRule();
		$secgrprule->update();
	}

  /**
   * @group v1_5
   * @group unit
   */
  public function testCanGetSecurityGroupRelationship() {
		$this->setMockResponse(
      ClientFactory::getClient('1.5'),
      array(
        '1.5/security_group_rule/json/response',
        '1.5/security_group/json/response'
      )
    );
		$secGrpRule = new SecurityGroupRule();
    $secGrpRule->find_by_id('12345');
    $secGrp = $secGrpRule->security_group();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\Mc\SecurityGroup', $secGrp);
  }
    
}