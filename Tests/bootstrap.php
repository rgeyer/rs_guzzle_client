<?php

if(!isset($_ENV['ACCT_NUM'])) {
  $_ENV['ACCT_NUM'] = getenv('ACCT_NUM');
}

if(!isset($_ENV['EMAIL'])) {
  $_ENV['EMAIL'] = getenv('EMAIL');
}

if(!isset($_ENV['PASSWORD'])) {
  $_ENV['PASSWORD'] = getenv('PASSWORD');
}

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
	    		'acct_num' 	=> $_ENV['ACCT_NUM'],
    			'email'			=> $_ENV['EMAIL'],
    			'password'	=> $_ENV['PASSWORD'],
    			'version'		=> '1.0',
          'curl.CURLOPT_SSL_VERIFYHOST' => false,
          'curl.CURLOPT_SSL_VERIFYPEER' => false
    		)
    ),
		'test.guzzle-rs-1_5' => array(
        'class' 	=> 'RGeyer\Guzzle\Rs\RightScaleClient',
    		'params' 	=> array(
	    		'acct_num' 	=> $_ENV['ACCT_NUM'],
    			'email'			=> $_ENV['EMAIL'],
    			'password'	=> $_ENV['PASSWORD'],
    			'version'		=> '1.5',
          'curl.CURLOPT_SSL_VERIFYHOST' => false,
          'curl.CURLOPT_SSL_VERIFYPEER' => false
    		)
    )
)));

RGeyer\Guzzle\Rs\Common\ClientFactory::setCredentials($_ENV['ACCT_NUM'], $_ENV['EMAIL'], $_ENV['PASSWORD']);
# This is added to compensate for a broken curl implementation in Zend Studio when debugging or running PHP unit
RGeyer\Guzzle\Rs\Common\ClientFactory::setAdditionalParams(array('curl.CURLOPT_SSL_VERIFYPEER' => false));

date_default_timezone_set('America/Los_Angeles');