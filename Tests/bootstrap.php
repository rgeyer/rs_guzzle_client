<?php

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('America/Los_Angeles');

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'composer.lock')) {
    die("Dependencies must be installed using composer:\n\ncomposer.phar install --install-suggests\n\n"
        . "See https://github.com/composer/composer/blob/master/README.md for help with installing composer\n");
}

require_once 'PHPUnit/TextUI/TestRunner.php';

// Register an autoloader for the client being tested
spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Guzzle\\Rs')) {
        $class = str_replace('Guzzle\\Rs', '', $class);
        if ('\\' != DIRECTORY_SEPARATOR) {
            $class = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        } else {
            $class = dirname(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php';
        }
        if (file_exists($class)) {
            require $class;
        }
    }
});

// Include the composer autoloader
$loader = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . '.composer' . DIRECTORY_SEPARATOR . 'autoload.php';

// Register services with the GuzzleTestCase
Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'mock');

// Create a service builder to use in the unit tests
Guzzle\Tests\GuzzleTestCase::setServiceBuilder(\Guzzle\Service\ServiceBuilder::factory(array(
    'test.guzzle-rs-1_0' => array(
        'class' => 'Guzzle\Rs\RightScaleClient',
        'params' => array(
            'acct_num' => $_SERVER['ACCT_NUM'],
            'email'    => $_SERVER['EMAIL'],
            'password' => $_SERVER['PASSWORD'],
            'version'  => '1.0'
        )
    )
)));

Guzzle\Rs\Common\ClientFactory::setCredentials($_SERVER['ACCT_NUM'], $_SERVER['EMAIL'], $_SERVER['PASSWORD']);
