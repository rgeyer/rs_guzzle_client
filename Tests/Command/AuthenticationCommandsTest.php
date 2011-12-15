<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Http\Plugin\CookiePlugin;
use Guzzle\Http\CookieJar\ArrayCookieJar;
use Guzzle\Http\Message\Response;
use Guzzle\Rs\Tests\Utils\ClientCommandsBase;

class AuthenticationCommandsTest extends ClientCommandsBase {
	
	public function testCookieJarIsRFC2109Compliant() {
		$cookieJar = new ArrayCookieJar();
		$cookiePlugin = new CookiePlugin($cookieJar);		
		
		$headerAry = array(
			'Set-Cookie' => 'rs_gbl=eNotkNtugkAURX-lOc-Mcc4IDCRN6qVVEbWoiZcXM8CoEC4tF0GM_15I-r7WTvZ6ggAT4gco4OdgPqHMZQbmACnjLwUKD0zKEDWdYx8VCPyWZhdDcwcaJ9TlSCiVlBi6MAhFRpmPjPmaaPcK-e9yddC57TysDpEc74JkldVpVDmu7genhMaj6cS-l8PL2vo93Azk9VagdsvQJqvNkqv6p_9TUqvZuSQIKS-3RRq4RUnqxh7dxuy8P9jTxna-5dyrrGa2H6j7taXLBZmGI1x-DaNZVaF3vudqyP1IHzZOHp7jZTxZJGtsDkdyXGja_uEjwXq-uchtcHL4e5ek7pIkIm6vwOYhkrepfLR9FBCel5ZJASbDvqEqIGMRRC2UtVDv2kEfWXC9FbknItnz0hherz-gCW7u; domain=.rightscale.com; path=/; HttpOnly'
		); 
		
		$response = new Response(204, $headerAry, "body");
		
		$cookiePlugin->extractCookies($response);
		
		$this->assertEquals(1, count($cookieJar->getCookies('my.rightscale.com')));		
	}
	
	public function testCookieJarIsNotRFC2965Compliant() {
		$cookieJar = new ArrayCookieJar();
		$cookiePlugin = new CookiePlugin($cookieJar);		
		
		$headerAry = array(
			'Set-Cookie' => 'rs_gbl=eNotkNtugkAURX-lOc-Mcc4IDCRN6qVVEbWoiZcXM8CoEC4tF0GM_15I-r7WTvZ6ggAT4gco4OdgPqHMZQbmACnjLwUKD0zKEDWdYx8VCPyWZhdDcwcaJ9TlSCiVlBi6MAhFRpmPjPmaaPcK-e9yddC57TysDpEc74JkldVpVDmu7genhMaj6cS-l8PL2vo93Azk9VagdsvQJqvNkqv6p_9TUqvZuSQIKS-3RRq4RUnqxh7dxuy8P9jTxna-5dyrrGa2H6j7taXLBZmGI1x-DaNZVaF3vudqyP1IHzZOHp7jZTxZJGtsDkdyXGja_uEjwXq-uchtcHL4e5ek7pIkIm6vwOYhkrepfLR9FBCel5ZJASbDvqEqIGMRRC2UtVDv2kEfWXC9FbknItnz0hherz-gCW7u; domain=rightscale.com; path=/; HttpOnly'
		); 
		
		$response = new Response(204, $headerAry, "body");
		
		$cookiePlugin->extractCookies($response);
		
		$this->assertEquals(0, count($cookieJar->getCookies('my.rightscale.com')));		
	}

}

?>