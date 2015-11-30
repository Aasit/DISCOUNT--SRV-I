<?php
/**
 * Copyright © 2014 Native5
 * 
 * All Rights Reserved.  
 * Licensed under the Native5 License, Version 1.0 (the "License"); 
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at
 *  
 *      http://www.native5.com/legal/npl-v1.html
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Schemes
 * @package   Akzo\Scheme
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Akzo\Scheme;

/**
 * CommandQueue
 * 
 * @category  Schemes
 * @package   Akzo\Scheme
 * @author    Anurag Dadheech <anurag.dadheech@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-06-2014
 * Last Modified : Fri Jun 20 13:30:00 2014
 */
class CommandQueue
{
    
    protected $logger;
    protected $app;
    protected $config;

    const NAMESPACE_SEPARATOR = '::';
    const PART_SEPARATOR = '_';
    const PROCESS_ID_SEPARATOR = '.';

    /**
     * 
     * @var Singleton
     */
    private static $_instance;

    /**
     * __construct 
     * 
     * @access private
     * @return void
     */
    private function __construct() {
        $this->logger = $GLOBALS['logger'];
        $this->app = $GLOBALS['app'];
        $this->config = $GLOBALS['app']->getConfiguration()->getRawConfiguration('scheme');
    }

    /**
     * getInstance 
     * 
     * @access public
     * @return instance
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getNextSchemeAction($keyType) {
        // Get all action keys
        if ($keyType === \Akzo\Scheme\Cache\KeyType::GENERATE_PDF) {
            $execKey = $this->_buildPDFGenerationKey(
                '*',
                $keyType,
                \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION,
                '*'
            );
        } else {
            $execKey = $this->_buildExecutionKey(
                '*',
                $keyType,
                \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION,
                '*'
            );
        }
            
        $actionKeys = \Akzo\Scheme\Cache::getInstance()->listKeys(
            $execKey
        );

	if (empty($actionKeys)) {
	    return null;
	}

        $GLOBALS['logger']->info("All action keys for keyType [ $keyType ]: ".print_r($actionKeys, 1));

        // Iterate through the target action keys & get the data and check
        foreach ($actionKeys as $idx=>$actionKey) {
            $actionData = \Akzo\Scheme\Cache::getInstance()->getMap($actionKey);

            $GLOBALS['logger']->info("Iterating through key [ $actionKey ] with data: ".print_r($actionData, 1));

            // If code or type does not exist, delete this action and BYPASS
            if (!isset($actionData[\Akzo\Scheme\ExecuteActionAttribute::CODE])
                    || empty($actionData[\Akzo\Scheme\ExecuteActionAttribute::CODE])) {
                $GLOBALS['logger']->error("No CODE in Illegal key [ $actionKey ]. Deleting");

                // Delete this action
                \Akzo\Scheme\Cache::getInstance()->deleteKey($actionKey);
                // skip this action
                continue;
            }

            // If state does not exist:
            if (!isset($actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE])) {
                $GLOBALS['logger']->info("No STATE in key [ $actionKey ]. Setting to run..");

                // Setup this action for running
                $this->setupActionForRunning($actionKey, $actionData);
                // force set offset to zero
                $this->_setActionDealerOffset(
                    $actionKey,
                    0
                );
                // send back this action
                return \Akzo\Scheme\Cache::getInstance()->getMap($actionKey);
            }

            // If state is waiting or not running:
            if (($actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE] == \Akzo\Scheme\Cache\ExecuteActionState::NOT_RUNNING)
                    || ($actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE] == \Akzo\Scheme\Cache\ExecuteActionState::WAITING)) {
                $GLOBALS['logger']->info("Waiting or Not Running STATE in key [ $actionKey ]. Setting to run..");

                // Setup this action for running
                $this->setupActionForRunning($actionKey, $actionData);
                // send back this action
                return \Akzo\Scheme\Cache::getInstance()->getMap($actionKey);
            }

            // If state is running: 
            if ($actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE] == \Akzo\Scheme\Cache\ExecuteActionState::RUNNING) {
                // If pid does not exist or process with pid is not currently running
                if (!isset($actionData[\Akzo\Scheme\ExecuteActionAttribute::PID])
                        || !$this->_checkActionPidExists($actionData[\Akzo\Scheme\ExecuteActionAttribute::PID])) {
                    $GLOBALS['logger']->info("Running STATE in key [ $actionKey ] but no PID set. Setting to run..");

                    // Setup this action for running
                    $this->setupActionForRunning($actionKey, $actionData);
                    // send back this action
                    return \Akzo\Scheme\Cache::getInstance()->getMap($actionKey);
                }

                // If pid Exists and is running then continue to next action
                continue;
            }

            $GLOBALS['logger']->error("Illegal STATE in key [ $actionKey ]. Deleting..");

            // Fall Back for unsupported action state: Delete this action
            \Akzo\Scheme\Cache::getInstance()->deleteKey($actionKey);
        }

        // No actions to be run
        return null;
    }

    public function setupActionForRunning($actionKey, $actionData) {
        // set state as running
        $this->_setActionState(
            $actionKey,
            \Akzo\Scheme\Cache\ExecuteActionState::RUNNING
        );

        // If dealerOffset does not exist set it to zero
        $typecastedDealerOffset = (int)$actionData[\Akzo\Scheme\ExecuteActionAttribute::DEALER_OFFSET];
        if (!isset($actionData[\Akzo\Scheme\ExecuteActionAttribute::DEALER_OFFSET])
            || (($actionData[\Akzo\Scheme\ExecuteActionAttribute::DEALER_OFFSET] !== 0)
                && empty($typecastedDealerOffset))) {
            $this->_setActionDealerOffset(
                $actionKey,
                0
            );
        }

        // set this pid
        $this->_setActionPid(
            $actionKey,
            $this->_buildSelfProcessUniqId()
        );

        return true;
    }


    // ****** Execution Action Related Functions ****** //
    public function setSchemeAction(
        $code,
        $keyType,
        $type,
        $dealerOffset = 0,
        $state = null,
        $pid = null
    )
    {
        // Build the action key
        if ($keyType === \Akzo\Scheme\Cache\KeyType::GENERATE_PDF) {
            $actionKey = $this->_buildPDFGenerationKey(
                    $code,
            $keyType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION
                );
        } else {
            $actionKey = $this->_buildExecutionKey(
                    $code,
            $keyType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION,
            $type
                );
        }
        // Delete the action key before setting it again
        \Akzo\Scheme\Cache::getInstance()->deleteKey($actionKey);

        // Build the action data
        $actionData = array();
        $actionData[\Akzo\Scheme\ExecuteActionAttribute::CODE] = $code;
        $actionData[\Akzo\Scheme\ExecuteActionAttribute::TYPE] = $type;
        $actionData[\Akzo\Scheme\ExecuteActionAttribute::DEALER_OFFSET] = $dealerOffset;
        if (!is_null($state)) {
            $actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE] = $state;
        }
        if (!is_null($pid)) {
            $actionData[\Akzo\Scheme\ExecuteActionAttribute::PID] = $pid;
        }

        $this->logger->info("Setting action for scheme code {$code}: "
            ." execution data type {$type} | dealer Offset {$dealerOffset} | state {$state} | pid {$pid}");

        // Set the action map
        return \Akzo\Scheme\Cache::getInstance()->setMap(
            $actionKey,
            $actionData
        );
    }

    public function removeSchemeAction(
        $code,
        $type,
        $keyType
    )
    {
        // Build the action key
        $actionKey = $this->_buildExecutionKey(
            $code,
            $keyType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION,
            $type
        );

        $this->logger->info("Removing action for scheme code {$code}: execution data type {$type}");

        // Delete the action key before setting it again
        \Akzo\Scheme\Cache::getInstance()->deleteKey($actionKey);
    }

    


    //Private function start here
    private function _checkActionPidExists($compositePid) {
        // Get the pid from the composite pid
        $pidParts = explode(self::PROCESS_ID_SEPARATOR, $compositePid);

        // pid to check
        $pid = $pidParts[1];
        if (!isset($pidParts[1])) {
            return false;
        }

        // If pid exists and its gid is same as the recorded one
        if (posix_getpgid($pid) == $pidParts[0]) {
            return true;
        }

        return false;
    }

    private function _setActionState($actionKey, $state) {
        return \Akzo\Scheme\Cache::getInstance()->setMapAttribute(
            $actionKey,
            \Akzo\Scheme\ExecuteActionAttribute::STATE,
            $state
        );
    }

    private function _setActionDealerOffset($actionKey, $offset) {
        return \Akzo\Scheme\Cache::getInstance()->setMapAttribute(
            $actionKey,
            \Akzo\Scheme\ExecuteActionAttribute::DEALER_OFFSET,
            (int)$offset
        );
    }

    private function _setActionPid($actionKey, $pid) {
        return \Akzo\Scheme\Cache::getInstance()->setMapAttribute(
            $actionKey,
            \Akzo\Scheme\ExecuteActionAttribute::PID,
            $pid
        );
    }

    private function _buildSelfProcessUniqId() {
        return posix_getpgrp()
            .self::PROCESS_ID_SEPARATOR.posix_getpid();
    }

    private function _buildExecutionKey(
        $code, 
        $keyType,
        $executeKeyType,
        $dataType
    )
    {
        return $this->_buildKey(
            $code,
            $keyType,
            $dataType,
            $executeKeyType
        );
    }

    private function _buildPDFGenerationKey(
        $schemeID, 
        $keyType,
        $executeKeyType
    )
    {
        return $this->_buildKey(
            $schemeID,
            $keyType,
            null,
            $executeKeyType
        );
    }

    private function _buildKey(
        $code,
        $keyType,
        $dataType = null,
        $executeKeyType = null
    )
    {
        $config = $GLOBALS['app']->getConfiguration()->getRawConfiguration('scheme');
        $KEY_NAMESPACE = $config['namespace'];
        return $KEY_NAMESPACE
            .self::NAMESPACE_SEPARATOR.$code
            .self::NAMESPACE_SEPARATOR
                .$keyType
                .( empty($dataType) ? '' : self::PART_SEPARATOR.$dataType )
                .( empty($executeKeyType) ? '' : self::PART_SEPARATOR.$executeKeyType );
    }


}

