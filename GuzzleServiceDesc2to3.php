<?php

$xml_path = '/Users/ryangeyer/Code/PHP/rs_guzzle_client/src/RGeyer/Guzzle/Rs/rs_guzzle_client_v1.5.xml';
$json_path = '/Users/ryangeyer/Code/PHP/rs_guzzle_client/src/RGeyer/Guzzle/Rs/rs_guzzle_client_v1.5.json';
$xml = new \SimpleXMLElement(file_get_contents($xml_path));
$json = array('description' => 'RightScale API 1.5 Client', 'operations' => array(), 'models' => array());
foreach($xml->commands->xpath('command') as $command) {
  $command_json = array(
    'summary' => strval($command->doc)
  );
  $command_attributes = $command->attributes();
  $command_name = strval($command_attributes['name']);
  $command_json['class'] = str_replace('.', '\\', strval($command_attributes['class']));

  $params = array();
  foreach($command->xpath('param') as $param) {
    $param_attributes = $param->attributes();
    switch($param_attributes['name']) {
      case "path":
        $command_json['uri'] = isset($param_attributes['static']) ? strval($param_attributes['static']) : strval($param_attributes['default']);
        break;
      case "method":
        $command_json['httpMethod'] = strval($param_attributes['static']);
        break;
      case "return_class":
        $command_json['responseClass'] = strval($param_attributes['static']);
        break;
      default:
        $param_opts = array();
        foreach($param_attributes as $param_key => $param_value) {
          if(!in_array(strval($param_key), array('name', 'path', 'method', 'return_class'))) {
            $value = null;
            switch(strval($param_key)) {
              case "required":
                $value = (strval($param_value) == "true");
                break;
              case "location":
                if (strval($param_value) == "path") {
                  $value = "uri";
                } else {
                  $value = strval($param_value);
                }
                break;
              case "type":
                if(stripos(strval($param_value), 'enum') === 0) {
                  $value = "string";
                  $param_opts['enum'] = explode(',',str_replace('enum:', '', strval($param_value)));
                } else {
                  $value = strval($param_value);
                }
                break;
              default:
                $value = strval($param_value);
            }
            $param_opts[strval($param_key)] = $value;
          }
        }
        $params[strval($param_attributes['name'])] = $param_opts;
        break;
    }
  }

  $command_json['parameters'] = $params;
  $json['operations'][$command_name] = $command_json;
}

file_put_contents($json_path, json_encode($json, JSON_PRETTY_PRINT));