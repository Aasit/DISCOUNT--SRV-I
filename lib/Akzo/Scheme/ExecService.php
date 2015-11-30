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
 * ExecService
 * 
 * @category  Schemes
 * @package   Akzo\Scheme
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-06-2014
 * Last Modified : Fri Jun 20 13:30:00 2014
 */
class ExecService
{
    const NAMESPACE_SEPARATOR = '::';
    const PART_SEPARATOR = '_';

    protected $logger;
    protected $app;
    protected $config;

    protected static $remoteRuleApiEnabled = false;

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
        self::$remoteRuleApiEnabled = $this->config['ruleApiEnabled'];
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

    public function checkExecutionStatus($code, $executionDataType) {
        $cache = \Akzo\Scheme\Cache::getInstance();

        // Build the action key
        $actionKey = $this->_buildExecutionKey(
            $code,
            $executionDataType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION
        );

        // Build status, cumulated result and per-dealer result keys for this scheme and execution Data Type
        list($statusKey, $cumulatedResultKey, $perDealerResultKey) = $this->_buildExecutionResultKeys($code, $executionDataType);

        // Check if an action is set or cumulated Result Exist, if yes scheme is either under or has completed execution for the code and execution type
        if ($cache->keyExists($cumulatedResultKey)) {
            // Return execution status and data
            return array(
                'status' => $cache->getValue($statusKey),
                //'data' => $cache->getList($code, \Akzo\Scheme\Cache\KeyType::SIMULATION_RESULT),
                'newData' => $cache->getMap($perDealerResultKey),
                'cumulatedData' => json_decode($cache->getValue($cumulatedResultKey), true)
            );
        } else if ($cache->keyExists($actionKey)) {
            // Action key is set, but the execution has not started
            return array(
                'status' => \Akzo\Scheme\ProcessStatus::JUST_STARTED
            );
        } else {
            // If cumulated result does not exist or action Key is not set for this scheme and execution Type, return not started as status
            return array(
                'status' => \Akzo\Scheme\ProcessStatus::NOT_STARTED
            );
        }
    }


    public function checkPDFCreationStatus($code, $executionDataType) {
        $cache = \Akzo\Scheme\Cache::getInstance();

        // Build status, action key for this scheme's pdf genration
        $actionKey = $this->_buildPDFGenerationKey(
            $code,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION
        );

        $statusKey = $this->_buildPDFGenerationKey(
            $code,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::STATUS
        );

        if ($cache->keyExists($statusKey)) {
            // Return execution status
            return array(
                'status' => $cache->getValue($statusKey)
            );
        } else if ($cache->keyExists($actionKey)) {
            // Action key is set, but the pdf generation has not started
            return array(
                'status' => \Akzo\Scheme\ProcessStatus::JUST_STARTED
            );
        } else {
            // If neither action of status key is set, return pdf generation status as not started
            return array(
                'status' => \Akzo\Scheme\ProcessStatus::NOT_STARTED
            );
        }
    }
    
    public function execute(
        $code,
        $executionDataType, // target or actual
        \Akzo\Scheme\Data $data, // scheme data
        $groupDealersByCreditCode = true,
        $offset,
        $count
    )
    {
        if (empty($code) || empty($executionDataType) || empty($data)) {
            throw new \InvalidArgumentException("Invalid scheme code or execution data type or scheme data");
        }

        $this->logger->info("Executing scheme {$code}: "
            ." execution data type {$executionDataType} | dealer Offset {$offset} | count {$count}");

        // Local cache instance
        $cache = \Akzo\Scheme\Cache::getInstance();

        // Perform initialization for the first set of execution
        if ($offset == 0) {
            // Clear cache of any existing execution result for this scheme and execution data type
            $this->_resetExecutionData($code, $executionDataType);
        }

        // Build status, cumulated result and per-dealer result keys for this scheme and execution Data Type
        list($statusKey, $cumulatedResultKey, $perDealerResultKey) = $this->_buildExecutionResultKeys($code, $executionDataType);

        // Bug Fix: Plugin the scheme id - it might be empty
        $data->schemeHeaderTemplate->id = $data->schemeHeaderTemplate->schemeHeader->id = $code;

        // Scheme dealers as per the offset
        //TODO: change required
        $allDealers = $this->_loadSchemeDealers(
            $data->schemeHeaderTemplate->schemeHeader->salesGeography,
            $data->schemeHeaderTemplate->schemeHeader->dealerAttributes,
            $data->schemeHeaderTemplate->schemeHeader->segment,
            $groupDealersByCreditCode
        );

        // Check if more dealers are left to be executed
        list ($moreDealersLeft, $moreDealersOffset, $dealers)
            = $this->_calculateIfMoreDealers($code, $allDealers, $offset, $count);
        unset($allDealers);

        // Create the execution data object from the scheme data object before the loop
        $execData = $this->_convertDataToExecData($data);

        // Create execution Json for each dealer and execute it
        $idx = 0;
        $cumulatedResult = json_decode($cache->getValue($cumulatedResultKey), true);
        foreach ($dealers as $dealerCode=>$dealer) {
            // Check if the execution is to be continued or aborted ??
            $this->_abortExecution($code, $executionDataType);

            // Use dealer code or dealer credit code based on what to collate by
            if ($groupDealersByCreditCode) {
                $dealerCode = $dealer->credit_code;
            } else {
                $dealerCode = $dealer->code;
            }

            // Run Simulation for this dealer and get the result and updated cumulated Result
            list($dealerResult, $cumulatedResult) = $this->_executeSchemeForDealer(
                $execData,
                $dealer,
                $executionDataType,
                $groupDealersByCreditCode,
                $cumulatedResult
            );

            // Check if the execution is to be continued or aborted ??
            $this->_abortExecution($code, $executionDataType);

            // Update cumulated Result
            $cache->setValue($cumulatedResultKey, json_encode($cumulatedResult));

            // Check if the execution is to be continued or aborted ??
            $this->_abortExecution($code, $executionDataType);

            // Update the per dealer result
            $cache->setMapAttribute($perDealerResultKey, $dealerCode, json_encode($dealerResult));

            // Check if the execution is to be continued or aborted ??
            $this->_abortExecution($code, $executionDataType);

            $GLOBALS['logger']->info("Simulation complete for scheme $code Dealer #".($offset + $idx + 1)." [ {$dealerCode} ]");
            //if (($offset + $idx + 1) == 890 && function_exists('xdebug_start_trace'))
                //xdebug_start_trace();
            
            // Bump simulation status as soon as result for the first dealer is computed
            if ($offset == 0 && $idx == 0) {
                $cache->setValue($statusKey, \Akzo\Scheme\ProcessStatus::PARTIAL);
            }

            // Check if the execution is to be continued or aborted ??
            $this->_abortExecution($code, $executionDataType);

            unset($dealer);
            $idx++;
        }

        // Check if the execution is to be continued or aborted ??
        $this->_abortExecution($code, $executionDataType);

        // Simulation done only if all dealers have been dealt with
        if (!$moreDealersLeft) {
            $cache->setValue($statusKey, \Akzo\Scheme\ProcessStatus::READY);
        }

        return array(
            'status' => true,
            'moreDealersLeft' => $moreDealersLeft,
            'moreDealersOffset' => $moreDealersOffset
        );
    }

    public function executeSchemeForDealer(
        \Akzo\Scheme\Data $data,
        \Akzo\Dealer $dealer,
        $executionDataType,
        $cumulatedResult = array()
    ) 
    {
        $executionData = $this->_convertDataToExecData($data);
        // $this->logger->info("Temp: ".print_r($executionData,1));
        return $this->_executeSchemeForDealer(
            $executionData,
            $dealer,
            $executionDataType,
            false,
            $cumulatedResult
        );
    }

    public function getSchemeDealers($code, \Akzo\Scheme\Data $data, $groupDealersByCreditCode = true) {
        return $this->_loadSchemeDealers(
            $data->schemeHeaderTemplate->schemeHeader->salesGeography,
            $data->schemeHeaderTemplate->schemeHeader->dealerAttributes,
            $data->schemeHeaderTemplate->schemeHeader->segment,
            $groupDealersByCreditCode
        );
    }

    public function resetSchemeExecution($code) {
        // Reset the execution actions and kill the process if required
        $this->_resetExecutionAction($code, \Akzo\Scheme\ExecuteActionDataType::ACTUAL);
        $this->_resetExecutionAction($code, \Akzo\Scheme\ExecuteActionDataType::TARGET);

        // Now reset the execution action
        $this->_resetExecutionData($code, \Akzo\Scheme\ExecuteActionDataType::ACTUAL);
        $this->_resetExecutionData($code, \Akzo\Scheme\ExecuteActionDataType::TARGET);

        // TODO: Reset historical execution data also
    }


    public function buildPDFKeys($schemeID) {
       return $this->_buildPDFGenerationKey(
            $schemeID,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION
        );
    }

    // ****** Private Functions Follow ****** //

    // ****** Execution Action Related Private Functions ****** //

    const PROCESS_ID_SEPARATOR = '.';
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

    //private function _killActionPid($compositePid) {
        //$GLOBALS['logger']->info("Killing pid: $compositePid");

        //// Get the pid from the composite pid
        //$pidParts = explode(self::PROCESS_ID_SEPARATOR, $compositePid);

        //if (!isset($pidParts[1])) {
            //return false;
        //}

        //// pid to kill
        //$pid = $pidParts[1];

        //if (!empty($pid)) {
            //return posix_kill($pid, 15);
        //}

        //return true;
    //}

    // ****** Execution Cache Key Related Functions ****** //

    private function _buildExecutionResultKeys($code, $type) {
        // Return status, cumulated result and per-dealer result keys for this scheme and execution Type
        return array(
            $this->_buildExecutionKey(
                $code,
                $type,
                \Akzo\Scheme\Cache\CommandQueueActionKeyType::STATUS
            ),
            $this->_buildExecutionKey(
                $code,
                $type,
                \Akzo\Scheme\Cache\ExecuteActionKeyType::CUMULATED_RESULT
            ),
            $this->_buildExecutionKey(
                $code,
                $type,
                \Akzo\Scheme\Cache\ExecuteActionKeyType::PER_DEALER_RESULT
            )
        );
    }

    private function _buildExecutionKey(
        $code, 
        $dataType,
        $executeKeyType
    )
    {
        return $this->_buildKey(
            $code,
            \Akzo\Scheme\Cache\KeyType::EXECUTE,
            $dataType,
            $executeKeyType
        );
    }

    private function _buildPDFGenerationKey(
        $schemeID, 
        $executeKeyType
    )
    {
        return $this->_buildKey(
            $schemeID,
            \Akzo\Scheme\Cache\KeyType::GENERATE_PDF,
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

    // ****** Handling Execution Results ****** //

    private function _executeSchemeForDealer(
        \Akzo\Scheme\ExecData $execData,
        \Akzo\Dealer $dealer,
        $executionDataType,
        $dealerGroupedByCreditCode = true,
        $cumulatedResult = array()
    ) 
    {
        // Use dealer code or dealer credit code based on what to collate by
        if ($dealerGroupedByCreditCode) {
            $dealerCode = $dealer->credit_code;
        } else {
            $dealerCode = $dealer->code;
        }

        // Generate the execution Json for this dealer
        $filledExecData = $execData->toRuleEngineDealerExecData(
            $dealer,
            $executionDataType,
            'json'
        );

        // Placeholders populated into the JSON
        file_put_contents(
            getcwd().'/logs/executeScheme/'.$execData->sid.'-'.$dealerCode.'-'.$executionDataType.'-execute.log',
            $filledExecData
        );

        // Execute the scheme using the rule engine
        $ruleService = new \Akzo\Scheme\RemoteRuleService;
        $result = json_decode(
            $ruleService->executeScheme(
                $execData->sid,
                $filledExecData
            ),
            true
        );

        // Log Execution result
        file_put_contents(
            getcwd().'/logs/executeScheme/'.$execData->sid.'-'.$dealerCode.'-'.$executionDataType.'-result.log',
            json_encode($result)
        );

        // Marshall the current result and update the cumulated result
        $res = $this->_collateExecutionResults(
            $result,
            $cumulatedResult,
            $dealerCode
        );

	return $res;
    }

    private function _collateExecutionResults($result, $existingResult, $code) {
        $mapper = new \JsonMapper();
        $resultsData = $mapper->map($result, new \Akzo\Scheme\ResultData());

        // Initialize the result arrays
        $collatedResult = $this->_initializeResult(array());
        // Add the code to this data
        $collatedResult['code'] = $code;

        $existingResult = $this->_initializeResult($existingResult);

        // Collate the results
        list($collatedResult['inBills'], $existingResult['inBills'])
                = $this->_collateOutputs($resultsData->inBills, $existingResult['inBills']);
        list($collatedResult['ppiOutputs'], $existingResult['ppiOutputs'])
                = $this->_collateOutputs($resultsData->ppiOutputs, $existingResult['ppiOutputs']);
        list($collatedResult['priOutputs'], $existingResult['priOutputs'])
                = $this->_collateOutputs($resultsData->priOutputs, $existingResult['priOutputs']);
        list($collatedResult['slabOutputs'], $existingResult['slabOutputs'])
                = $this->_collateOutputs($resultsData->slabOutputs, $existingResult['slabOutputs']);
        list($collatedResult['slabV2Outputs'], $existingResult['slabV2Outputs'])
                = $this->_collateOutputs($resultsData->slabV2Outputs, $existingResult['slabV2Outputs']);

        return array( 
            $collatedResult,
            $existingResult
        );
    }

    private function _initializeResult($result) {
        $result = $this->_initializeResultKeys($result, 'inBills');
        $result = $this->_initializeResultKeys($result, 'ppiOutputs');
        $result = $this->_initializeResultKeys($result, 'priOutputs');
        $result = $this->_initializeResultKeys($result, 'slabOutputs');
        $result = $this->_initializeResultKeys($result, 'slabV2Outputs');
        return $result;
    }

    private function _initializeResultKeys($result, $key) {
        if (!isset($result[$key])) {
            $result[$key] = array();
        }
        return $result;
    }

    private function _collateOutputs($outputs, $existingResults) {
        $collatedOutputs = array();
        if (empty($outputs) || !is_array($outputs)) {
            return array($collatedOutputs, $existingResults);
        }
        if (empty($existingResults)) {
            $existingResults = array();
        }

        foreach ($outputs as $idx=>$output) {
            // TODO: Discard if tplId is not set
            if (empty($output->tplId)) {
                $output->tplId = 0;
            }
            // Initialize for this output
            if (!isset($collatedOutputs[$output->tplId])) {
                $collatedOutputs[$output->tplId] = array();
            }
            if (!isset($existingResults[$output->tplId])) {
                $existingResults[$output->tplId] = array();
            }

            // Just one WITHOUT_QC entry for a template
            if (strcasecmp($output->ruleGroup, \Akzo\Scheme\ResultData\GroupType::WITHOUT_QC) === 0) {
                // Set the collated results
                if (isset($collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC])) {
                    $collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC] += $output->dniPayout;
                } else {
                    $collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC] = $output->dniPayout;
                }

                // Initialize existing Results if empty
                if (!isset($existingResults[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC])) {
                    $existingResults[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC] = 0;
                }
                $existingResults[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC] += $output->dniPayout;
            } else {
                // Multiple WITH_QC entries for a template
                // Set the highest value among the WITH_QC entries
                if (!isset($collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC])
                    || ($output->dniPayout > $collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC])) {
                    // Initialize this collated output
                    if (!isset($collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC])) {
                        $collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC] = 0;
                    }

                    // For with QC values, need to multiply with the payoutConditionApplicable
                    $dniPayout = $output->dniPayout * $output->payoutConditionApplicable;

                    // Store the earlier result and set the current one instead
                    $earlierOutput = $collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC];
                    $collatedOutputs[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC] = $dniPayout;

                    // Initialize existing Results if empty
                    if (!isset($existingResults[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITHOUT_QC])) {
                        $existingResults[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC] = 0;
                    }
                    // Add only the difference to the cumulated result
                    $existingResults[$output->tplId][\Akzo\Scheme\ResultData\GroupType::WITH_QC]
                            += ($dniPayout - $earlierOutput);
                }
            }
        }

        // Sort the arrays by their keys before sending them back
        ksort($collatedOutputs);
        ksort($existingResults);

        // Return the sorted arrays
        return array($collatedOutputs, $existingResults);
    }

    // ****** Scheme Dealer Related Helper Functions ****** //

    public function _calculateIfMoreDealers($code, $allDealers, $offset, $count) {
        $totalDealers = count($allDealers);
        $GLOBALS['logger']->info("Total number of dealers: ".$totalDealers);
        $moreDealersLeft = false; $moreDealersOffset = 0;
        if ($totalDealers > ($offset + $count)) {
            $moreDealersLeft = true;
            $moreDealersOffset = $offset + $count;
        }

        // Dealers for which the scheme will be executed in this invocation
        $dealers = array_slice($allDealers, $offset, $count, true);
        file_put_contents(
            getcwd().'/logs/executeScheme/'.$code.'_dealers_'.($offset+1).'-'.($offset + $count).'.log',
            "Scheme Execution JSON: ".PHP_EOL.print_r($dealers, 1)
        );

        return array($moreDealersLeft, $moreDealersOffset, $dealers);
    }

    private function _loadSchemeDealers($salesGeography, $dealerAttributes, $segment, $groupDealersByCreditCode = true, $offset = 0, $count = null) {
        $dealers = array();
        // Get depots by geography
        foreach ($salesGeography as $idx=>$geo) {
            $dealer = \Akzo\Geography\Service::getInstance()->getDealersByGid(
                    $geo->gid,
                    $dealerAttributes,
                    $segment,
                    $groupDealersByCreditCode,
                    $offset,
                    $count
             );
	    $dealers = array_merge(
                $dealers,
            	$dealer
	    );
        }
	
        
        // TODO: Have a better code for this
        // Index dealer objects by their code
        $codeIndexedDealers = array();
        foreach ($dealers as $idx=>$dealer) {
            // Use dealer code or dealer credit code based on what to collate by
            if ($groupDealersByCreditCode) {
		$this->logger->info("dealer: |||||||||||||||||||||||| ".$idx." ||||||||||  ".print_r($dealer->credit_code,1));
                $codeIndexedDealers[$dealer->credit_code] = $dealer;
            } else {
                $codeIndexedDealers[$dealer->code] = $dealer;
            }

        }


        return $codeIndexedDealers;
    }

    // ****** \Akzo\Scheme\ExecData related functions ****** //
    private function _convertDataToExecData(\Akzo\Scheme\Data $data) {
        // Create the execution data object from the scheme data object
        $execData = new \Akzo\Scheme\ExecData;
        $mapper = new \BCC\AutoMapperBundle\Mapper\Mapper;
        $mapper->registerMap(new \Akzo\Scheme\Mapper\DataToExecDataMap);
        $mapper->map($data, $execData);
        file_put_contents(
            getcwd().'/logs/tests/'.$data->schemeHeaderTemplate->schemeHeader->id.'-execData.log',
            print_r($execData, 1)
        );

        return $execData;
    }

    // ****** Cache Related Functions ****** //

    private function _resetExecutionAction($code, $executionDataType, $stopRunningAction = true) {
        // Build the action key
        $actionKey = $this->_buildExecutionKey(
            $code,
            $executionDataType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ACTION
        );

        // Stop a running job if it exists
        if ($stopRunningAction) {
            $actionData = \Akzo\Scheme\Cache::getInstance()->getMap($actionKey);

            // Set Execution Abort only if state is running and process with pid exists
            if (!empty($actionData) 
                    && isset($actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE])
                    && ( $actionData[\Akzo\Scheme\ExecuteActionAttribute::STATE] == \Akzo\Scheme\Cache\ExecuteActionState::RUNNING )
                    && isset($actionData[\Akzo\Scheme\ExecuteActionAttribute::PID])
                    && $this->_checkActionPidExists($actionData[\Akzo\Scheme\ExecuteActionAttribute::PID])) {

                $this->_setExecutionAbort($code, $executionDataType);
            }
        }

        // Clear the action key now
        return \Akzo\Scheme\Cache::getInstance()->deleteKey($actionKey);
    }

    private function _setExecutionAbort($code, $executionDataType) {
        $this->logger->info("Settin Execution Abort Command for scheme {$code} and execution data type {$executionDataType}");

        // Build the action key
        $stopActionKey = $this->_buildExecutionKey(
            $code,
            $executionDataType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ABORT_ACTION
        );

        // Set the abort execution key
        \Akzo\Scheme\Cache::getInstance()->setValue($stopActionKey, 1);
    }

    private function _abortExecution($code, $executionDataType) {
        // Build the action key
        $stopActionKey = $this->_buildExecutionKey(
            $code,
            $executionDataType,
            \Akzo\Scheme\Cache\CommandQueueActionKeyType::ABORT_ACTION
        );

        // Check if the key exists
        if (\Akzo\Scheme\Cache::getInstance()->keyExists($stopActionKey)) {
            $this->logger->info("Aborting Execution for scheme {$code} and execution data type {$executionDataType}");

            // Delete the key
            \Akzo\Scheme\Cache::getInstance()->deleteKey($stopActionKey);
            // Exit
            exit;
        }
    }

    private function _resetExecutionData($code, $executionDataType) {
        // Get the execution related keys for this scheme and execution data type
        list($statusKey, $cumulatedResultKey, $perDealerResultKey) = $this->_buildExecutionResultKeys($code, $executionDataType);

        // Clear the keys
        $cache = \Akzo\Scheme\Cache::getInstance();
        $cache->deleteKey($statusKey);
        $cache->deleteKey($cumulatedResultKey);
        $cache->deleteKey($perDealerResultKey);
    }
}

