<?php
namespace RGeyer\Guzzle\Rs\Tests\Command\Ec2;

use RGeyer\Guzzle\Rs\Tests\Utils\ClientCommandsBase;

/**
 * TODO: Creation throws 500 so can't test anything.
 *
 */
class VpcDhcpOptionsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_vpc_href;
	
	public static function setUpBeforeClass() {
		
	}
	
	public static function tearDownAfterClass() {
		
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateVpcDhcpOptions() {
		$this->markTestSkipped("Even with correct parameters, this throws 500!");
		$command = null;
		$result = $this->executeCommand('vpc_dhcp_options_create',
			array(
				'vpc_dhcp_options[name]' => 'Guzzle_Test_' . $this->_testTs,
				'vpc_dhcp_options[domain_name]' => 'foo.bar'
			),
			$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$vpc_id = $this->getIdFromHref('vpc_dhcp_options', $command->getResponse()->getHeader('Location'));
		
		return $vpc_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateVpcDhcpOptions
	 */
	public function testCanDestroyVpcDhcpOptions($id) {
		$command = null;
		$result = $this->executeCommand('vpc_dhcp_options_destroy', array('id' => $id), $command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		
	}
	
}