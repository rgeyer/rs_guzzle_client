<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Ec2;

use RGeyer\Guzzle\Rs\Model\Ec2\Server;

class ServerTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testExtendsAbstractSecurityGroup() {
    $server = new Server();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\AbstractServer', $server);
  }
}