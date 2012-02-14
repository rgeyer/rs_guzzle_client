<?php
namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class CredentialCommandsTest extends ClientCommandsBase {
	
	protected static $testTs;
	protected static $_credential_href;
	
	public static function setUpBeforeClass() {
		self::$testTs = time();
		$testClassToApproximateThis = new CredentialCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$command = null;
		$result = $testClassToApproximateThis->executeCommand('credentials_create',
			array(
				'credential[name]' => 'GUZZLE_TEST_CRED_' . self::$testTs,
				'credential[value]' => 'val'
			),
			&$command
		);
		
		self::$_credential_href = $command->getResponse()->getHeader('Location');
	}
	
	public static function tearDownAfterClass() {		
		$testClassToApproximateThis = new CredentialCommandsTest();
		$testClassToApproximateThis->setUp();
		
		$regex = ',https://.+/api/acct/[0-9]+/credentials/([0-9]+),';
		$matches = array();
		preg_match($regex, self::$_credential_href, $matches);
		
		$cred_id = $matches[1];
		
		$testClassToApproximateThis->executeCommand('credentials_destroy', array('id' => $cred_id));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanCreateCredential() {
		$command = null;
		$result = $this->executeCommand('credentials_create',
			array(
				'credential[name]' => 'GUZZLE_TEST_CRED_' . $this->_testTs,
				'credential[value]' => 'val',
				'credential[description]' => 'described'
			),
			&$command
		);
		
		$this->assertEquals(201, $command->getResponse()->getStatusCode());
		$this->assertNotNull($command->getResponse()->getHeader('Location'));
		
		$regex = ',https://.+/api/acct/[0-9]+/credentials/([0-9]+),';
		$matches = array();
		preg_match($regex, $command->getResponse()->getHeader('Location'), $matches);
		
		$cred_id = $matches[1];
		
		return $cred_id;
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 * @depends testCanCreateCredential
	 */
	public function testCanDestroyCredential($cred_id) {
		$command = null;
		$result = $this->executeCommand('credentials_destroy', array('id' => $cred_id), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListCredentialsJson() {
		$command = null;
		$result = $this->executeCommand('credentials', array(), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertGreaterThan(0, count($json_obj));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanListCredentialsXml() {
		$command = null;
		$result = $this->executeCommand('credentials', array('output_format' => '.xml'), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertGreaterThan(0, count($result->credential));
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowCredentialJson() {
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('GUZZLE_TEST_CRED_' . self::$testTs, $json_obj->name);
		$this->assertEquals('val', $json_obj->value);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanShowCredentialXml() {
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href), 'output_format' => '.xml'), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$this->assertInstanceOf('SimpleXMLElement', $result);
		$this->assertEquals('GUZZLE_TEST_CRED_' . self::$testTs, $result->name);
		$this->assertEquals('val', $result->value);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateCredentialName() {
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('NameChanged', $json_obj->name);
		
		$command = null;
		$result = $this->executeCommand('credentials_update',
			array(
				'id' => $this->getIdFromHref('credentials', self::$_credential_href),
				'credential[name]' => 'NameChanged'
			),
			&$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
		
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('NameChanged', $json_obj->name);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateCredentialValue() {
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('ValChanged', $json_obj->value);
		
		$command = null;
		$result = $this->executeCommand('credentials_update',
			array(
				'id' => $this->getIdFromHref('credentials', self::$_credential_href),
				'credential[value]' => 'ValueChanged'
			),
			&$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
		
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('ValueChanged', $json_obj->value);
	}
	
	/**
	 * @group v1_0
	 * @group integration
	 */
	public function testCanUpdateCredentialDescription() {
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertNotEquals('DescriptionChanged', $json_obj->description);
		
		$command = null;
		$result = $this->executeCommand('credentials_update',
			array(
				'id' => $this->getIdFromHref('credentials', self::$_credential_href),
				'credential[description]' => 'DescriptionChanged'
			),
			&$command
		);		
		$this->assertEquals(204, $command->getResponse()->getStatusCode());		
		
		$command = null;
		$result = $this->executeCommand('credential', array('id' => $this->getIdFromHref('credentials', self::$_credential_href)), &$command);
		$this->assertEquals(200, $command->getResponse()->getStatusCode());
		$json_obj = json_decode($result->getBody(true));
		$this->assertEquals('DescriptionChanged', $json_obj->description);
	}
}