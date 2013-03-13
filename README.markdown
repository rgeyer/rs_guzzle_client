Guzzle Rightscale API client for PHP
==========================================

[![Build Status](https://travis-ci.org/rgeyer/rs_guzzle_client.png)](https://travis-ci.org/rgeyer/rs_guzzle_client)

rs_guzzle_client is a PHP Guzzle REST API client library for the RightScale API.

Support is available for v1.0 of the API and v1.5 support is coming soon!

## Installation
Add rs_guzzle_client to the src/Guzzle/Rs directory of your Guzzle
installation:

    cd /path/to/guzzle
    git submodule add git://github.com/rgeyer/rs_guzzle_client.git ./src/Guzzle/Rs

You can now build a phar file containing guzzle-aws and the main guzzle framework:

    cd /path/to/guzzle/build
    phing phar

Now you just need to include guzzle.phar in your script.  The phar file
will take care of autoloading Guzzle classes:

```php

    <?php
    require_once 'guzzle.phar';
```

The example script for getting your servers:
```php
<?php
    require_once 'guzzle.phar';
    $serviceBuilder = \Guzzle\Service\ServiceBuilder::factory(array(
    'guzzle-rs-1_0' => array(
        'class'     => 'RGeyer\Guzzle\Rs\RightScaleClient',
        'params'     => array(
            'acct_num'     => '00000', // your rightscale account id
            'email'            => 'your@email.com',
            'password'    => 'yourPassword',
            'version'        => '1.0',
            'curl.CURLOPT_SSL_VERIFYHOST' => false,
            'curl.CURLOPT_SSL_VERIFYPEER' => false,
        )
    ),
    ));

    $client = $serviceBuilder->get('guzzle-rs-1_0');

    $params = array();
    $command = $client->getCommand('servers', $params);

```

## API coverage
Below you will find the current controllers (and their commands) that are supported by the library.  A quick legend for the completeness percentage.

100% - Implemented Commands, Full tests, Mock responses in the library
50% - Implemented Commands, Not tested or minimally tested, Mocks may or may not exist
0% - Not implemented

<!-- 
<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3"></th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
-->

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Alert Spec Subjects</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Alert Spec</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Audit Entries</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Component EC2 EBS Volumes</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Servers</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>launch</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>start</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A (see launch above)</td>
    </tr>
    <tr>
      <td>start_ebs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A (see launch above)</td>
    </tr>
    <tr>
      <td>terminate</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>stop</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A (see terminate above)</td>
    </tr>
    <tr>
      <td>stop_ebs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A (see terminate above)</td>
    </tr>
    <tr>
      <td>reboot</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>run_script</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>run_executable</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>attach_volume</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>settings</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>get_sketchy_data</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>current/show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>current/update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>current/settings</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>alert_specs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>monitoring</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>monitoring/graph-name</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">100%</td>
      <td bgcolor="orange">20% (Lacks all reference commands/models)</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Credentials</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Deployments</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>duplicate</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>clone</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>start_all</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>stop_all</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">EC2 EBS Snapshots</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">EC2 EBS Volumes</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">EC2 Elastic IPs</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Security Groups</th>
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Security Group Rules</th>
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Server Arrays</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>terminate_all</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>multi_terminate</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>launch</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>run_script_on_all</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>multi_run_executable</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>instances</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>current_instances</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">EC2 SSH Keys</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Macros</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Multi Cloud Images</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>clone</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>commit</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">MultiCloudImageSettings</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Right Scripts</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">S3 Bucket</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Server Template</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>executables</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>alert_specs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>clone</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>commit</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>publish</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="orange">50% (Lacks all relationship commands/models)</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">SQS Queues</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Statuses</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Tags</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>search</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>set</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>unset</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>taggable_resources</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>tags_by_resource</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>tags_by_tag</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>tags_multi_add</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>tags_multi_delete</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>
  
<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">VPC DHCP Option</th>      
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>create</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Clouds</th>
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Publications</th>
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>import</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
  </tbody>
</table>

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">Instances</th>
    </tr>
    <tr>
      <th width="120px">Command</th>
      <th width="120px">v1.0</th>
      <th width="120px">v1.5</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>show</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>update</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>launch</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>multi_run_executable</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>multi_terminate</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>reboot</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>run_executable</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td>set_custom_lodgement</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">N/A Deprecated for InstanceCustomLodgments#create</td>
    </tr>
    <tr>
      <td>terminate</td>
      <td bgcolor="green">N/A</td>
      <td bgcolor="green">100%</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
  </tbody>
</table>

TODO
====
* Allow the user to specify a logger.
* ModelBase "duplicate" and "clone" should both work on either Ec2 or Mc classes.
* Handle the HTTP 500 seek() null error
* Reduce (or eliminate) the need for the ServiceBuilder and ClientFactory
* Allow OAuth token authentication
* ModelBase should assume that the API call for a relationship is the same as the relationship name, unless specified otherwise.  I.E. relationship for 'cloud' would call command 'cloud' with an ID
* Refactor tagging functionality into ModelBase or an "IsTaggable" mixin class.  See Model\Mc\Server for example of how *not* to do it