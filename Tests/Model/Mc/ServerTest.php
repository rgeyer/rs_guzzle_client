<?php

namespace RGeyer\Guzzle\Rs\Test\Model\Mc;

use RGeyer\Guzzle\Rs\Model\Mc\Server;

class ServerTest extends \Guzzle\Tests\GuzzleTestCase {

  /**
   * @group v1_0
   * @group unit
   */
  public function testExtendsAbstractServer() {
    $server = new Server();
    $this->assertInstanceOf('RGeyer\Guzzle\Rs\Model\AbstractServer', $server);
  }
}