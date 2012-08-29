<?php

require_once 'vendor/autoload.php';

// Autoload classes for guzzle-rs
spl_autoload_register(function($class) {
    if (0 === strpos($class, 'RGeyer\Guzzle\Rs\Tests\\')) {
        $path = implode('/', array_slice(explode('\\', $class), 4)) . '.php';
        require_once __DIR__ . '/' . $path;
        return true;
    }
    if (0 === strpos($class, 'RGeyer\Guzzle\Rs\\')) {
        $path = implode('/', explode('\\', $class)) . '.php';
        require_once __DIR__ . '/../src/' . $path;
        return true;
    }
});

// Register services with the GuzzleTestCase
Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'mock');

// Create a service builder to use in the unit tests
Guzzle\Tests\GuzzleTestCase::setServiceBuilder(\Guzzle\Service\Builder\ServiceBuilder::factory(array(
    'test.guzzle-rs-1_0' => array(
        'class' 	=> 'RGeyer\Guzzle\Rs\RightScaleClient',
    		'params' 	=> array(
	    		'acct_num' 	=> $_SERVER['ACCT_NUM'],
    			'email'			=> $_SERVER['EMAIL'],
    			'password'	=> $_SERVER['PASSWORD'],
    			'version'		=> '1.0'
    		)
    ),
		'test.guzzle-rs-1_5' => array(
        'class' 	=> 'RGeyer\Guzzle\Rs\RightScaleClient',
    		'params' 	=> array(
	    		'acct_num' 	=> $_SERVER['ACCT_NUM'],
    			'email'			=> $_SERVER['EMAIL'],
    			'password'	=> $_SERVER['PASSWORD'],
    			'version'		=> '1.5'
    		)
    )
)));

RGeyer\Guzzle\Rs\Common\ClientFactory::setCredentials($_SERVER['ACCT_NUM'], $_SERVER['EMAIL'], $_SERVER['PASSWORD']);
# This is added to compensate for a broken curl implementation in Zend Studio when debugging or running PHP unit
RGeyer\Guzzle\Rs\Common\ClientFactory::setAdditionalParams(array('curl.CURLOPT_SSL_VERIFYPEER' => false));

date_default_timezone_set('America/Los_Angeles');