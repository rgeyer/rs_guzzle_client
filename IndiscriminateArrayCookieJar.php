<?php
// Copyright 2011 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at

// http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Guzzle\Rs;

use Guzzle\Common\Collection;
use Guzzle\Http\CookieJar\ArrayCookieJar;

/**
 * A variation of ArrayCookieJar which returns ALL cookies in the jar.
 * 
 * This is a heavy handed hack to handle the fact that Guzzle is not RFC2965 compliant, but rather RFC2109
 * Which effectively means that Guzzle will not send back the cookie set for rightscale.com when a new request
 * is for anything other than the exact hostname "rightscale.com".  I.E. requests to my.rightscale.com
 * will not include the cookies set for rightscale.com.
 * 
 * http://tools.ietf.org/html/rfc2109
 * http://tools.ietf.org/html/rfc2965
 * 
 * @author Ryan J. Geyer <me@ryangeyer.com>
 *
 */
class IndiscriminateArrayCookieJar extends ArrayCookieJar {
	
	public function getCookies($domain = null, $path = null, $name = null, $skipDiscardable = false, $skipExpired = true) {
		return parent::getCookies();
	}

}

?>