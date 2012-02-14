rs_guzzle_client is a PHP Guzzle REST API client library for the RightScale API.

Support is available for v1.0 of the API and v1.5 support is coming soon!

Below you will find the current controllers (and their commands) that are supported by the library.

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
      <td bgcolor="red">0%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td>destroy</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="green">N/A</td>
    </tr>
    <tr>
      <td><b>Model</b></td>
      <td bgcolor="red">0%</td>
      <td bgcolor="green">N/A</td>
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
      <td>start</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>start_ebs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>stop</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>stop_ebs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>reboot</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>run_script</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>run_executable</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>attach_volume</td>
      <td bgcolor="orange">50%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>settings</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>get_sketchy_data</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>current/show</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>current/update</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>current/settings</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>alert_specs</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>monitoring</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>monitoring/graph-name</td>
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
      <td>duplicate</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>start_all</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>stop_all</td>
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

<br/>

<table border="1" width="360px">
  <thead>
    <tr>
      <th colspan="3">EC2 Security Groups</th>      
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
      <td>terminate_all</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>launch</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>run_script_on_all</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>instances</td>
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
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
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
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
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
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>index</td>
      <td bgcolor="green">100%</td>
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
      <td>executables</td>
      <td bgcolor="red">0%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>alert_specs</td>
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
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>set</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>unset</td>
      <td bgcolor="green">100%</td>
      <td bgcolor="red">0%</td>
    </tr>
    <tr>
      <td>taggable_resources</td>
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