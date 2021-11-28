<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\OSConfig;

class OSPolicyAssignmentReport extends \Google\Collection
{
  protected $collection_key = 'osPolicyCompliances';
  public $instance;
  public $lastRunId;
  public $name;
  public $osPolicyAssignment;
  protected $osPolicyCompliancesType = OSPolicyAssignmentReportOSPolicyCompliance::class;
  protected $osPolicyCompliancesDataType = 'array';
  public $updateTime;

  public function setInstance($instance)
  {
    $this->instance = $instance;
  }
  public function getInstance()
  {
    return $this->instance;
  }
  public function setLastRunId($lastRunId)
  {
    $this->lastRunId = $lastRunId;
  }
  public function getLastRunId()
  {
    return $this->lastRunId;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setOsPolicyAssignment($osPolicyAssignment)
  {
    $this->osPolicyAssignment = $osPolicyAssignment;
  }
  public function getOsPolicyAssignment()
  {
    return $this->osPolicyAssignment;
  }
  /**
   * @param OSPolicyAssignmentReportOSPolicyCompliance[]
   */
  public function setOsPolicyCompliances($osPolicyCompliances)
  {
    $this->osPolicyCompliances = $osPolicyCompliances;
  }
  /**
   * @return OSPolicyAssignmentReportOSPolicyCompliance[]
   */
  public function getOsPolicyCompliances()
  {
    return $this->osPolicyCompliances;
  }
  public function setUpdateTime($updateTime)
  {
    $this->updateTime = $updateTime;
  }
  public function getUpdateTime()
  {
    return $this->updateTime;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(OSPolicyAssignmentReport::class, 'Google_Service_OSConfig_OSPolicyAssignmentReport');
