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
 * Service
 * 
 * @category  Schemes
 * @package   Akzo\Scheme
 * @author    Shamik Datta <barry@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-06-2014
 * Last Modified : Fri Jun 20 13:30:00 2014
 */
class Service
{
    protected $logger;
    protected $dao;
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
        $this->dao = new \Akzo\Scheme\DAOImpl();
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

    // ******** Scheme related actions handled through the Scheme State Machine ******** //

    public function stageScheme(\Akzo\User $user, $schemeJson) {
        $scheme = $this->_buildSchemeForSM($user, null, $schemeJson);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'Staged'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::STAGE_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::STAGE_SCHEME);
        }

        return $schemeSM->getObject();
    }

    public function updateScheme(\Akzo\User $user, $schemeJson, $schemeCode) {
        $this->_checkSchemeCode($schemeCode);

        $scheme = $this->_buildSchemeForSM($user, $schemeCode, $schemeJson);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'Staged'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::UPDATE_STAGED_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::UPDATE_STAGED_SCHEME);
        } else if ($schemeSM->can(\Akzo\Scheme\StateTransition::UPDATE_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::UPDATE_SCHEME);
        }

        return $schemeSM->getObject();
    }

    public function initiateScheme(\Akzo\User $user, $schemeJson, $schemeCode = null) {
        $scheme = $this->_buildSchemeForSM($user, $schemeCode, $schemeJson);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'To Be Reviewed'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::INITIATE_CREATED_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::INITIATE_CREATED_SCHEME);
        } else if ($schemeSM->can(\Akzo\Scheme\StateTransition::INITIATE_STAGED_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::INITIATE_STAGED_SCHEME);
        } else if ($schemeSM->can(\Akzo\Scheme\StateTransition::INITIATE_UPDATED_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::INITIATE_UPDATED_SCHEME);
        }

        return $schemeSM->getObject();
    }

    public function reviewScheme(\Akzo\User $user, $schemeCode, $comment) {
        $this->_checkSchemeCode($schemeCode);

        $scheme = $this->_buildSchemeForSM($user, $schemeCode, null, $comment);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'To Be Approved'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::REVIEW_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::REVIEW_SCHEME);
        }

        return $schemeSM->getObject();
    }

    public function approveScheme(\Akzo\User $user, $schemeCode, $comment) {
        $this->_checkSchemeCode($schemeCode);

        $scheme = $this->_buildSchemeForSM($user, $schemeCode, null, $comment);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'To Be Approved'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::APPROVE_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::APPROVE_SCHEME);
        }

        return $schemeSM->getObject();
    }

    public function requestSchemeUpdate(\Akzo\User $user, $schemeCode, $comment) {
        $this->_checkSchemeCode($schemeCode);

        $scheme = $this->_buildSchemeForSM($user, $schemeCode, null, $comment);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'To Be Approved'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE);
        }

        return $schemeSM->getObject();
    }

    public function requestSchemeReview(\Akzo\User $user, $schemeCode, $comment) {
        $this->_checkSchemeCode($schemeCode);

        $scheme = $this->_buildSchemeForSM($user, $schemeCode, null, $comment);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'To Be Approved'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::REQUEST_SCHEME_REVIEW)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::REQUEST_SCHEME_REVIEW);
        }

        return $schemeSM->getObject();
    }

    public function editApprovedScheme(\Akzo\User $user, $schemeCode, $comment) {
        $this->_checkSchemeCode($schemeCode);

        $scheme = $this->_buildSchemeForSM($user, $schemeCode, null, $comment);

        // TODO: Validate the schemeJson

        // Initiate the state machine with the created scheme
        $schemeSM = new \Akzo\Scheme\StateMachine($scheme);

        // Make the state transition to 'To Be Approved'
        if ($schemeSM->can(\Akzo\Scheme\StateTransition::EDIT_APPROVED_SCHEME)) {
            $schemeSM->apply(\Akzo\Scheme\StateTransition::EDIT_APPROVED_SCHEME);
        }

        return $schemeSM->getObject();
    }

    // ****** Scheme Execution Related Functions Follow ****** //

    public function getSchemeExecutionResult(
        $code,
        $executionDataType = \Akzo\Scheme\ExecuteActionDataType::TARGET,
        $groupDealersByCreditCode = true    // FIXME: Unused
    )
    {
        // Load the scheme from the database
        $this->_checkSchemeCode($code);

        // Check the status of the simulation of the scheme, if not started start it
        $result = \Akzo\Scheme\ExecService::getInstance()->checkExecutionStatus(
            $code,
            $executionDataType
        );

        // If execution has not started for this scheme and execution type, set an action for it with dealer offset 0
        if (strcmp($result['status'], \Akzo\Scheme\ProcessStatus::NOT_STARTED) === 0) {
            \Akzo\Scheme\CommandQueue::getInstance()->setSchemeAction(
                $code,
                \Akzo\Scheme\Cache\KeyType::EXECUTE,
                $executionDataType
            );
            $result['status'] = \Akzo\Scheme\ProcessStatus::JUST_STARTED;
        }

        return $result;
    }

    public function initiatePDFCreation(
        $schemeId,
        $executionDataType = \Akzo\Scheme\ExecuteActionDataType::TARGET
    )
    {
        // Load the scheme from the database
        $this->_checkSchemeCode($schemeId);

        // Check the status of the simulation of the scheme, if not started start it
        $result = \Akzo\Scheme\ExecService::getInstance()->checkPDFCreationStatus(
            $schemeId,
            $executionDataType
        );

        // If execution has not started for this scheme and execution type, set an action for it with dealer offset 0
        if (strcmp($result['status'], \Akzo\Scheme\ProcessStatus::NOT_STARTED) === 0) {
            \Akzo\Scheme\CommandQueue::getInstance()->setSchemeAction(
                $schemeId,
                \Akzo\Scheme\Cache\KeyType::GENERATE_PDF,
                $executionDataType
            );
            $result['status'] = \Akzo\Scheme\ProcessStatus::JUST_STARTED;
        }

        return $result;
    }

    public function executeScheme(
        $code,
        $executionDataType,
        $groupDealersByCreditCode = true,
        $dealerOffset = 0,
        $dealerCount = 10
    )
    {
        // Load the scheme from the database
        $this->_checkSchemeCode($code);
        $scheme = $this->dao->loadSchemeByCode($code);

        // Execute the scheme
        return \Akzo\Scheme\ExecService::getInstance()->execute(
            $code,
            $executionDataType,
            $this->_buildSchemeDataFromJson($scheme->data),
            $groupDealersByCreditCode,
            $dealerOffset,
            $dealerCount
        );
    }

    public function getSchemeDealers(
        $code,
        $groupByCreditCode = true
    )
    {
        // Load the scheme from the database
        $this->_checkSchemeCode($code);
        $scheme = $this->dao->loadSchemeByCode($code);
        
        return \Akzo\Scheme\ExecService::getInstance()->getSchemeDealers(
            $code,
            $this->_buildSchemeDataFromJson($scheme->data),
            $groupByCreditCode
        );
    }

    //public function initiateSimulation($code, $dealerOffset = 0, $dealerCount = 35) {
        //// Load the scheme from the database
        //$this->_checkSchemeCode($code);
        //$scheme = $this->dao->loadSchemeByCode($code);

        //// Execute the scheme
        //return \Akzo\Scheme\ExecService::getInstance()->simulate(
            //$code,
            //$this->_buildSchemeDataFromJson($scheme->data),
            //$dealerOffset,
            //$dealerCount
        //);
    //}

    //public function executeScheme($code) {
        //// Load the scheme from the database
        //$this->_checkSchemeCode($code);
        //$scheme = $this->dao->loadSchemeByCode($code);

        //// Execute the scheme
        //return \Akzo\Scheme\ExecService::getInstance()->execute(
            //$code,
            //$scheme->data,
            //$scheme->execution_template,
            //$scheme->execution_functions
        //);
    //}

    public function getNextSchemeAction() {
        return \Akzo\Scheme\ExecService::getInstance()->getNextSchemeAction();
    }

    // **** Functions directly interacting with the DAO **** //

    public function getSchemeByCode($schemeCode, $transformData = false) {
        $scheme = $this->dao->loadSchemeByCode($schemeCode);
        if ($transformData) {
            $scheme->data = $this->_buildSchemeDataFromJson($scheme->data);
        }
        
        return $scheme;
    }

    // Get scheme(s) through initiator
    public function getInitiatedScheme(\Akzo\User $user, $schemeCode) {
        return $this->dao->getInitiatedScheme($user, $schemeCode);
    }

    public function listDraftSchemes(\Akzo\User $user) {
        return $this->dao->getAllDraftSchemes($user)->toArray();
    }

    public function listInitiatedSchemes(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllInitiatedSchemes($user, $state)->toArray();
    }

    public function listInitaitedSchemeObjects(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllInitiatedSchemes($user, $state)->all();
    }

    // Get scheme(s) through reviewer
    public function getToBeReviewedScheme(\Akzo\User $user, $schemeCode) {
        return $this->dao->getToBeReviewedScheme($user, $schemeCode);
    }

    public function listToBeReviewedSchemes(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllToBeReviewedSchemes($user, $state)->toArray();
    }

    public function listToBeReviewedSchemeObjects(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllToBeReviewedSchemes($user, $state)->all();
    }

    // Get scheme(s) through approver
    public function getToBeApprovedScheme(\Akzo\User $user, $schemeCode) {
        return $this->dao->getToBeApprovedScheme($user, $schemeCode);
    }

    public function listToBeApprovedSchemes(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllToBeApprovedSchemes($user, $state)->toArray();
    }

    public function listToBeApprovedSchemeObjects(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllToBeApprovedSchemes($user, $state)->all();
    }

    // Get scheme(s) through payout approver
    public function getToBePayoutApprovedScheme(\Akzo\User $user, $schemeCode) {
        return $this->dao->getToBePayoutApprovedScheme($user, $schemeCode);
    }

    public function listToBePayoutApprovedSchemes(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllToBePayoutApprovedSchemes($user, $state)->toArray();
    }

    public function listToBePayoutApprovedObjects(\Akzo\User $user, $state = \Akzo\Scheme\State::STAGED) {
        return $this->dao->getAllToBePayoutApprovedSchemes($user, $state)->all();
    }

    public function getSchemesPendingApproval(\Akzo\User $user, $state = \Akzo\Scheme\State::TO_BE_APPROVED) {

        $initiatedSchemes = $this->dao->getinitiatedByState($user, $state)->all();
        $toBeApprovedSchemes = $this->dao->getApprovedByState($user, $state)->all();
        $toBeReviewedSchemes = $this->dao->getReviewedByState($user, $state)->all();
        return array_merge($initiatedSchemes, $toBeApprovedSchemes, $toBeReviewedSchemes);
    }

    public function getSchemesInitiated(\Akzo\User $user, $state = \Akzo\Scheme\State::TO_BE_REVIEWED) {
       $initiatedSchemes = $this->dao->getinitiatedByState($user, $state)->all();
        $toBeApprovedSchemes = $this->dao->getApprovedByState($user, $state)->all();
        $toBeReviewedSchemes = $this->dao->getReviewedByState($user, $state)->all();
        return array_merge($initiatedSchemes, $toBeApprovedSchemes, $toBeReviewedSchemes);
    }

     public function getSchemesConcluded(\Akzo\User $user, $state = \Akzo\Scheme\State::APPROVED) {
       $initiatedSchemes = $this->dao->getinitiatedByState($user, $state)->all();
        $toBeApprovedSchemes = $this->dao->getApprovedByState($user, $state)->all();
        $toBeReviewedSchemes = $this->dao->getReviewedByState($user, $state)->all();
        return array_merge($initiatedSchemes, $toBeApprovedSchemes, $toBeReviewedSchemes);
    }

    // ******** Static functions used by the Scheme State Machine ******** //

    public function createSaveScheme(\Akzo\Scheme $scheme) {
        // save the scheme to the Rule Engine and populate the sid/code
        $scheme->code = $this->_createSchemeRule($scheme->rules_data);

        // Reset any simulation/excution data for this scheme
        \Akzo\Scheme\ExecService::getInstance()->resetSchemeExecution($scheme->code);

        // Do not need to save the rules_data
        unset($scheme->rules_data);

        // Save scheme to database
        $scheme->save();

        // Update the scheme uid attribute
        return $this->_updateSchemeUid($scheme);
    }

    public function updateSaveScheme(\Akzo\Scheme $scheme) {
        // update the scheme in the Rule Engine & save the updated scheme to database
        $this->_updateSchemeRule($scheme->code, $scheme->rules_data);

        // Reset any simulation/excution data for this scheme
        \Akzo\Scheme\ExecService::getInstance()->resetSchemeExecution($scheme->code);

        // Do not need to save the rules_data
        unset($scheme->rules_data);

        // Save scheme to database
        $scheme->save();

        return $scheme;
    }

    public function generatePDFforDealers($schemeId, $path, $offset = 0, $count = 50)
    {
        $scheme = \Akzo\Scheme\Service::getInstance()->getSchemeByCode($schemeId);
        $uid = $scheme->uid;

        $allDealers = \Akzo\Scheme\ExecService::getInstance()->getSchemeDealers(
            $schemeId,
            $this->_buildSchemeDataFromJson($scheme->data)
        );

        list ($moreDealersLeft, $moreDealersOffset, $dealers)
            = \Akzo\Scheme\ExecService::getInstance()->_calculateIfMoreDealers($schemeId, $allDealers, $offset, $count);
        unset($allDealers);

        $fileName = $uid . "_" . ($offset + 1) . "-" . ($offset + $count) . ".pdf";

        $html = $this->_createHTML($scheme, $dealers);
        $GLOBALS['logger']->info("Got action to execute: ".$moreDealersOffset." .. ".$moreDealersLeft);
        $result = array();
        $result['pdfPath'] = $this->_createPDF($html, $path, $fileName);
        $result['moreDealersOffset'] = $moreDealersOffset;
        $result['moreDealersLeft'] = $moreDealersLeft;


        return $result;
    }

    public function generatePDF($schemeId, $path)
    {
        $scheme = \Akzo\Scheme\Service::getInstance()->getSchemeByCode($schemeId);
        $uid = $scheme->uid;

        $fileName = $uid . ".pdf";

        $html = $this->_createHTML($scheme);

        return $this->_createPDF($html, $path, $fileName);
    }

    public function getGeneratedPDFs($schemeId, $path)
    {
        $scheme = \Akzo\Scheme\Service::getInstance()->getSchemeByCode($schemeId);
        $uid = $scheme->uid;

        $pattern = $path . "/" . $uid . "_*";

        return [glob($pattern), $uid];
    }

    private function _createPDF($html, $path, $schemeFileName)
    {
        if(!file_exists($path)) {
            $GLOBALS['logger']->info("pathhhhhhh: ".$path);
            mkdir($path);
        }

        if(file_exists($path.'/'.$schemeFileName)) {
            unlink($path.'/'.$schemeFileName);
        }

        require_once __DIR__.'/../../html2pdf/html2pdf.class.php';

        $html2pdf = new \HTML2PDF('P','A4','en');
        $html2pdf->WriteHTML($html);
        $html2pdf->Output($path.'/'.$schemeFileName, 'F');

        return $path.'/'.$schemeFileName;
    }

    private function _createHTML($scheme, $dealers = null)
    {
        $data = array();
        // $GLOBALS['logger']->info("Sthlsdhldjfgld session: ".$GLOBALS['app']);
        // $data['nonce'] = urlencode($GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce'));
        $data['qcOperator'] = array(
            "GREATER_THAN_EQUALS"=>"Greater Than or Equal to",
            "LESS_THAN"=>"Less than"
        );
        $data['qcBasevalue'] = array(
            "HISTORICAL"=>"Historical",
            "TARGET"=>"Target",
            "GROWTH"=> "Growth",
            "ACTUAL"=>"Actual",
            "TARGET_ACHIEVEMENT"=> "Target Achievement",
            "RATIO"=> "Ratio"
        );

        $data["schemeDataRaw"] = $scheme->data;
        $data["schemeData"] = json_decode($scheme->data, 1);
        $data["state"] = $scheme->state;
        $data["schemeCode"] = $scheme->code;

        if(empty($dealers)) {
            $dealers = array(
                    array(
                        "name" => "<>",
                        "code" => "<>",
                        "address" => "<>"
                    )
                );
        }

        $data['dealers'] = $dealers;

        $retData = new \Native5\UI\BasicTwigRenderer('schemePDF.tmpl', __DIR__.'/../../../views/templates/common');
        return $retData->render($data);
    }

    private function _createSchemeRule($schemeRulesData) {
        if (self::$remoteRuleApiEnabled) {
            $ruleService = new \Akzo\Scheme\RemoteRuleService;
            $code = $ruleService->createScheme($schemeRulesData);
        } else {
            $code = 'MY_SCHEME_'.time();
        }

        return $code;
    }

    private function _updateSchemeRule($code, $schemeRulesData) {
            file_put_contents(
                getcwd().'/logs/tests/scheme.rules.data.log',
                $schemeRulesData
            );

        if (self::$remoteRuleApiEnabled) {
            $ruleService = new \Akzo\Scheme\RemoteRuleService;
            $ruleService->updateScheme(
                $code,
                $schemeRulesData
            );
        }

        return true;
    }

    private function _deleteSchemeRule($code, \Akzo\Scheme $scheme) {
        if (self::$remoteRuleApiEnabled) {
            $ruleService = new \Akzo\Scheme\RemoteRuleService;
            $ruleService->deleteScheme(
                $code
            );
        }

        return true;
    }

    private function _updateSchemeUid(\Akzo\Scheme $scheme) {
        // Need to add today's month / year
        $dT = new \DateTime();
        // Now retrieve the id of this scheme saved in DB, build the uid and save it again
        $scheme->uid = self::_getSchemeTypeIdentifier($scheme->type)
            .$dT->format("my")
            .str_pad($scheme->id, 6, "0", STR_PAD_LEFT);

        $scheme->save();

        return $scheme;
    }

    // ******** Private Functions Follow ******** //

    private function _buildNewSchemeModel(\Akzo\User $initiator) {
        $scheme = new \Akzo\Scheme;

        $scheme->initiator()->associate($initiator);
        $scheme->reviewer()->associate($initiator->identity->scheme_reviewer()->get()->first()->user()->get()->first());
        $scheme->approver()->associate($initiator->identity->scheme_approver()->get()->first()->user()->get()->first());
        $scheme->payout_approver()->associate($initiator->identity->scheme_payout_approver()->get()->first()->user()->get()->first());
        $scheme->state = \Akzo\Scheme\State::CREATED;

        return $scheme;
    }

    // **** Construct Scheme Object for processing by State Machine **** //
    private function _buildSchemeForSM(\Akzo\User $user, $code = null, $data = null, $comment = null) {
        // If this is a new scheme then build the base object
        if (empty($code)) {
            $scheme = $this->_buildNewSchemeModel($user);
        } else {
            $scheme = $this->dao->loadSchemeByCode($code);
        }

        // Fill in editable scheme attributes
        if ($scheme->is_editable) {
            // Check for empty data
            // $GLOBALS['logger']->info("DATA - ||||||".print_r($data,1)."|||||||||");
            if (empty($data)) {
                $this->_invokeInvalidSchemeDataException();
            }

            // Check for successful conversion to data object
            try {
                $schemeData = $this->_buildSchemeDataFromJson($data);
            } catch (\Exception $e) {
                $this->_invokeInvalidSchemeDataException();
            }
            if (empty($schemeData)) {
                $this->_invokeInvalidSchemeDataException();
            }
        
            file_put_contents(
                getcwd().'/logs/tests/scheme.data.log',
                print_r($schemeData, 1)
            );

            // Add extracted parameters from scheme
            $scheme->name = $schemeData->schemeHeaderTemplate->schemeHeader->name;
            $scheme->type = $schemeData->schemeHeaderTemplate->schemeHeader->type;

            // Dates need to converted to the storage date format
            $scheme->start_date
                    = $schemeData->schemeHeaderTemplate->schemeHeader->startDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT);
            $scheme->end_date 
                    = $schemeData->schemeHeaderTemplate->schemeHeader->endDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT);

            // Segment is an array - just json_encode it
            $scheme->segment = @json_encode($schemeData->schemeHeaderTemplate->schemeHeader->segment);

            // Dealer Attributes and sales Geography need to be converted to json
            $scheme->sales_geography = $this->_extractSchemeDataAttributes($schemeData->schemeHeaderTemplate->schemeHeader->salesGeography);
            $scheme->dealers_attributes = $this->_extractSchemeDataAttributes($schemeData->schemeHeaderTemplate->schemeHeader->dealerAttributes);

            // Needed for saving updated / created scheme to rules engine
            // Note: will not be saved to database
            $scheme->rules_data = $schemeData->toRuleEngineData('json');

            // Finally: Update the scheme data
            // TODO: Use ->toJson() method to generate json data back from constructed scheme data object
            $scheme->data = $data;

            // Update the comment if part of the scheme data object
            if (empty($comment) && !empty($schemeData->comment)) {
                $comment = $schemeData->comment;
            }

            //file_put_contents(
                //getcwd().'/logs/tests/ruleEngine.data.json',
                //$scheme->rules_data
            //);

            //file_put_contents(
                //getcwd().'/logs/executeScheme/'.$code.'_data.log',
                //"Scheme JSON: ".PHP_EOL.print_r($scheme->data, 1)
            //);
        }

        // If non-empty comment, add to the model
        if (!empty($comment)) {
            $scheme->setComment($comment);
        }

        return $scheme;
    }

    private function _extractSchemeDataAttributes($attributes) {
        $extractedAttributes = array();
        if (empty($attributes)) {
            return @json_encode($extractedAttributes);
        }

        // TODO: Change from ->toRuleEngineData() to ->toJson() method
        foreach ($attributes as $idx=>$attr) {
            $extractedAttributes[] = $attr->toRuleEngineData();
        }

        return @json_encode($extractedAttributes);
    }

    private function _invokeInvalidSchemeDataException() {
        throw new \InvalidArgumentException(
            "Invalid Scheme Data received.",
            \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
        );
    }

    private function _checkSchemeCode($code) {
        if (empty($code)) {
            throw new \Exception(
                "Cannot edit a scheme without an identifier",
                \Native5\Core\Http\StatusCodes::PRECONDITION_FAILED
            );
        }
    }

    private static function _getSchemeTypeIdentifier($type) {
        if (strcasecmp($type, "Monthly") === 0) {
            return "M";
        } else if (strcasecmp($type, "ATR") === 0) {
            return "A";
        } else if (strcasecmp($type, "QTR") === 0) {
            return "Q";
        } else if (strcasecmp($type, "Custom Scheme") === 0) {
            return "C";
        } 
    }

    public function _buildSchemeDataFromJson($jsonData, $format = 'json') {
        if (strcasecmp($format, 'json') === 0) {
            $jsonData = json_decode($jsonData);
        }
        if (empty($jsonData)) {
            return null;
        }

        $mapper = new \JsonMapper();
        return $mapper->map($jsonData, new \Akzo\Scheme\Data());
    }

    // TODO: Do all this in the state machine - remove this function
    public function savePublicTransition(\Akzo\Scheme $scheme, $stateTransition) {
        $transitionName = $stateTransition->getName();

        try {
            $transition = new \Akzo\Scheme\Transition;
            $transition->scheme()->associate($scheme);
            $transition->type = $transitionName;
            $transition->before_state = $stateTransition->getInitialStates()[0];
            $transition->after_state = $stateTransition->getState();
            $transition->comments = $scheme->getComment();

            if (strcmp($transitionName, \Akzo\Scheme\StateTransition::INITIATE_CREATED_SCHEME) === 0
                    || strcmp($transitionName, \Akzo\Scheme\StateTransition::INITIATE_STAGED_SCHEME) === 0
                    || strcmp($transitionName, \Akzo\Scheme\StateTransition::INITIATE_UPDATED_SCHEME) === 0) {
                $transition->user()->associate($scheme->initiator);
            } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REVIEW_SCHEME) === 0) {
                $transition->user()->associate($scheme->reviewer);
            } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::APPROVE_SCHEME) === 0) {
                $transition->user()->associate($scheme->approver);
            } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE) === 0
                    && in_array(\Akzo\Scheme\State::TO_BE_REVIEWED, $stateTransition->getInitialStates())) {
                $transition->before_state = \Akzo\Scheme\State::TO_BE_REVIEWED;
                $transition->user()->associate($scheme->reviewer);
            } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE) === 0
                    && in_array(\Akzo\Scheme\State::TO_BE_APPROVED, $stateTransition->getInitialStates())) {
                $transition->before_state = \Akzo\Scheme\State::TO_BE_APPROVED;
                $transition->user()->associate($scheme->approver);
            } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REQUEST_SCHEME_REVIEW) === 0) {
                $transition->user()->associate($scheme->approver);
            } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::EDIT_APPROVED_SCHEME) === 0) {
                $transition->user()->associate($scheme->initiator);
            }

            return $transition->save();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function addSchemeTransition(\Akzo\User $user, \Akzo\Scheme $scheme, $transition, $comment = null) {
        return $this->dao->addSchemeTransition($user, $scheme, $transition, $comment);
    }

    public function getSchemeTransitions(\Akzo\Scheme $scheme) {
        return $this->dao->loadSchemeTransitions($scheme);
    }
}

