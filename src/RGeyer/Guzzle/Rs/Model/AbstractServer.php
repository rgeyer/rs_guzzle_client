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

namespace RGeyer\Guzzle\Rs\Model;

use RGeyer\Guzzle\Rs\Model\ModelBase;

abstract class AbstractServer extends ModelBase {

  /**
   * Makes the appropriate API call to start/launch the server, optionally with the provided inputs
   *
   * @abstract
   * @param null $inputs An associative array where the key is the name of the input parameter to change, and the value is a value in the format <type>:<value>.  For instance text:foobar
   * @return void
   */
  public abstract function launch($inputs = null);

  public abstract function terminate();

  /**
   * Adds one or many tags to the server
   *
   * @abstract
   * @param array $tags An array of one or many tags to add to the server
   * @return void
   */
  public abstract function addTags(array $tags);

  /**
   * Deletes one or many tags from the server
   *
   * @abstract
   * @param array $tags An array of one or many tags to delete from the server
   * @return void
   */
  public abstract function deleteTags(array $tags);
}