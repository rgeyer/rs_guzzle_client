<?php

namespace Guzzle\Rs\Tests\Common;

use PHPUnit_Framework_TestCase;
use Guzzle\Rs\Common\ClientFactory;
use InvalidArgumentException;

/**
 * test case.
 */
class ClientFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp ();
        // TODO Auto-generated ClientFactoryTest::setUp()
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ClientFactoryTest::tearDown()
        parent::tearDown ();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
     * @group v1_0
     * @group unit
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWhenInvalidVersionSupplied()
    {
        ClientFactory::getClient("2.0");
    }
}