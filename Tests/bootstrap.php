<?php

require_once $_SERVER['GUZZLE'] . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Guzzle' => $_SERVER['GUZZLE'] . '/src',
    'Guzzle\\Tests' => $_SERVER['GUZZLE'] . '/tests'
));
$loader->register();

// Autoload classes for guzzle-rs-1_0
spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Guzzle\Rs\\')) {
        $path = implode('/', array_slice(explode('\\', $class), 2)) . '.php';
        require_once __DIR__ . '/../' . $path;
        return true;
    }
});

// Register services with the GuzzleTestCase
\Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'mock');

// Create a service builder to use in the unit tests
\Guzzle\Tests\GuzzleTestCase::setServiceBuilder(\Guzzle\Service\ServiceBuilder::factory(array(
    'test.guzzle-rs-1_0' => array(
        'class' 	=> 'Guzzle\Rs\RightScaleClient',
    		'params' 	=> array(
	    		'acct_num' 	=> $_SERVER['ACCT_NUM'],
    			'email'			=> $_SERVER['EMAIL'],
    			'password'	=> $_SERVER['PASSWORD'],
    			'version'		=> '1.0'
    		)
    )
)));

\Guzzle\Rs\Common\ClientFactory::setCredentials($_SERVER['ACCT_NUM'], $_SERVER['EMAIL'], $_SERVER['PASSWORD']);

date_default_timezone_set('America/Los_Angeles');