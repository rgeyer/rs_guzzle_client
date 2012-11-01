<?php
// Copyright 2012 Ryan J. Geyer
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
// http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace RGeyer\Guzzle\Rs\Model\Mc;

use RGeyer\Guzzle\Rs\Model\ModelBase;

class AlertSpec extends ModelBase {

  public function __construct($mixed = null) {
    $this->_api_version = '1.5';
    
    $this->_path = 'alert_spec';
    $this->_required_params = array(
      'alert_spec[condition]' => $this->castToString(),
      'alert_spec[duration]' => $this->castToString(),
      'alert_spec[file]' => $this->castToString(),
      'alert_spec[name]' => $this->castToString(),
      'alert_spec[threshold]' => $this->castToString(),
      'alert_spec[variable]' => $this->castToString()
    );    
    $this->_optional_params = array(
      'alert_spec[description]' => $this->castToString(),
      'alert_spec[escalation_name]' => $this->castToString(),
      'alert_spec[subject_href]' => $this->castToString(),
      'alert_spec[vote_tag]' => $this->castToString(),
      'alert_spec[vote_type]' => $this->castToString()
    );
    
    $this->_relationship_handlers = array(
      'server' => 'server',
      'server_array' => 'server_array',
      'server_template' => 'server_template'
    );
    
    parent::__construct($mixed);
  }

  public function duplicate() {
    throw new \BadMethodCallException($this->_path . " does not implement a duplicate method");
  }
  
  /**
   * Fetches the correct Model for the "subject" relationship.  This extends the functionality of the
   * __call() magic method since "subject" can be one of a few different resource types.
   * 
   * @throws \BadMethodCallException If there is no "subject" relationship link
   * @throws \UnexpectedValueException If the "subject"relationship link can not be parsed
   * 
   * @return RGeyer\Guzzle\Rs\Model\Mc\Server|RGeyer\Guzzle\Rs\Model\Mc\ServerArray|RGeyer\Guzzle\Rs\Model\Mc\ServerTemplate
   */
  public function subject() {
    $subjectLinkIdx = 0;
    $subjectHref = null;
    foreach($this->links as $idx => $link) {
      if($link->rel == 'subject') {
        $subjectLinkIdx = $idx;
        $subjectHref = $link->href;
      }
    }
    if(!$subjectHref) {
      throw new \BadMethodCallException('There was no link for "subject" returned by the API');
    }
    
    $matches = null;
    $regex = ',/api/([a-z_]*)s/,';
    $regRez = preg_match($regex, $subjectHref, $matches);
    if(!$regRez) {
      throw new \UnexpectedValueException(sprintf("The href for subject (%s) did not match the regex (%s)", $subjectHref, $regex));
    }
    # TODO: Maybe validate that the match is one of (server, server_array, server_template)?
    $this->links[$subjectLinkIdx]->rel = $matches[1];
    return $this->{$matches[1]}();    
  }
  
}