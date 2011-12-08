<?php

namespace Guzzle\Rs\Tests\Model;

use Guzzle\Rs\Model\SshKey;
use Guzzle\Rs\Common\ClientFactory;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class SshKeyTest extends ClientCommandsBase {
	
	protected function setUp() {
		parent::setUp();
		
		$this->setMockResponse(ClientFactory::getClient(), 'login');
		ClientFactory::getClient()->get('login')->send();		
	}
	
	public function testCanCreateKeySpecifyingParametersWithProperties() {		
		$this->setMockResponse(ClientFactory::getClient(), 'SshKey/create');
		
		$key = new SshKey();
		$key->aws_key_name = 'test';
		$key->create();
		$this->assertEquals(12345, $key->id);
	}

	public function testCanCreateKeySpecifyingParametersOnCreate() {		
		$this->setMockResponse(ClientFactory::getClient(), 'SshKey/create');

		$key = new SshKey();
		$key->create(array('ec2_ssh_key[aws_key_name]' => 'test'));
		$this->assertEquals(12345, $key->id);
	}
	
	public function testCanFindKeyById() {
		$this->setMockResponse(ClientFactory::getClient(), 'SshKey/show');
		$key = new SshKey();
		$key->find_by_id(12345);
		
		$key_material = <<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAtYPm7ZgwnbHr5dMIT5QRx6a5JHxOVUG5T4jEcIB/btD3Qm0WeIxuYm/q2zDU
Zwrs24AcYSuSECsnKh0NH1WKUieDvvwEF3/Hzdb+vyo5TUCoSdVDy3d46Qd6p7yh5gALkkVDPiGI
IX0NoahdOnXgVqSMhrPtHktM7Hnt1GdEvWBH228pJQ2n4UOYnJGkmv8Aw5x82o4+D39dv9iNQve2
pu6CH8NN4KnzUu9ImRmtsjS+kQrp5g3pq+xKYDFiRWUaJzSRlCcCKMmqrzn8yUbtsc/4tfHTh+EW
C1Ea6M6Sf2DsZgG9rSNjijuQNoRLxKheStcJLflzoXEUx8F0V4aCAQIDAQABAoIBAQC0uolixiaZ
zP5pDY731SFC3cD4EADaqJ7/DtkwfvDjAJNAg2ddTc3Wm0KHTf4ePuWIw+z93ykGikDrkJNxQHWB
yTBHJ5xXXXYugEOTSVJWles54GspGmK7+yNoAcxdOmxLDkWehjqJxX6eGAoDXDyraBk3Qcz1XdpQ
ljJ0SwJJXvelvHUkFb+JX32eBhI10k/yTjVw3+rnQuigYGSaseYubPqtKQce++ywiv95Y3S+XyYS
8teVzeeVzwQfjyHgzCM/12sYCl9Ag41mgv8tEFSUDtZMsbrEaLZw1u7RCH6lJO03dSW/7XnQhLRk
WnObOVv8LJaOIbLjsSB1wG3EkSzVAoGBAN0T5sI7xSiNLHT2dUo3Hjkkk5tCvHPQBG67ouUAux7y
JO44KfZqtMH84yynnYZRd03nfqQM3itdbvdsnOPbLlCpEQnfB4Fp3SPZqN1q+j/0h3Dezc474w90
QVI2coBlaB0CvDDdwE3yqhvcCy8opEvW79HxreK9QM+cilmUxY5nAoGBANIwJPEVfHkqJ8EGkkyK
rSXGgFrr3FYg71rUG3ZR8XPDuu+d2BqPn4T0BA0EmVqGdD1LqpLPnq2NQRtzptE71oECB6n3iXSU
luxJqA8JLxRgW2NUP0r74/73FI5Q2vi1QufwBsk4F5tpggRgoRLThnhlEDzayYUbxbM0+wLPR9tX
AoGAYMww8oSnG81MVN4AlwExK4X3VzjOOMsw1ac0eJ5sT+1n/CH9RZaNFI78jPXLBB+xZBvjGENG
F6iuSIl23FGAovKTskXEDIbku6i2xlPrxIr1rpbvd8hC7+ZQH4YVdmBwSJuE+MRvSfHhR5d+EiTy
Yv52PO9b2nZQ5VY+QWDhaysCgYBdx99jtduA0D9Gj6ENB77zoNq6Noxr3WwOUZ8jLrKVnVo1+W5n
g3eAQcPg7xFhY6ZPhwhHUt2Qv/qxvetLZfByRS6YNnsdCgNA0Chs9QMNi2SbMAbBdRwoMaP5T7gz
yeRdSios85sM24mIXHjhxoE0DJuvG0tY2ahfKh9pBIUiJwKBgBYFZkb8TYfPLirpkKoEGjTXc8Du
W38aUTWZy5yCTYEtioUnqlfvMzYSmsw3xH1W/CSOj3Qrzbf/nbu/Kph/uSUZgu3/pVjuQp5gHBkr
61ErOXpupw4X8mfKnRFSTrvoiuFB9+xc16pCVVv9hp9ekij64v63GvjcH0ITeBHAbq2a
-----END RSA PRIVATE KEY-----
EOF;
		
		$this->assertEquals(12345, $key->id);
		$this->assertEquals('f2:a3:5d:37:22:08:3c:60:fa:72:b0:0a:52:bc:c1:df:b4:ea:00:ef', $key->aws_fingerprint);
		$this->assertEquals('2011-12-03 00:29:24', $key->created_at->format('Y-m-d H:i:s'));
		$this->assertEquals('2011-12-03 00:29:24', $key->updated_at->format('Y-m-d H:i:s'));
		$this->assertEquals('https://my.rightscale.com/api/acct/12345/ec2_ssh_keys/12345', $key->href);
		$this->assertEquals($key_material, $key->aws_material);		
	}
	
	public function testCanDestroyAKey() {
		$this->setMockResponse(ClientFactory::getClient(), array('SshKey/show', 'SshKey/destroy'));
		$key = new SshKey();
		$key->find_by_id(12345);
		$result = $key->destroy();
		
		$this->assertEquals(200, $result->getStatusCode());
	}
}

?>