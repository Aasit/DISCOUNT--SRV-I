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
 * @category  Controllers 
 * @package   App/Controllers
 * @author    Anurag Dadheech <anurag.dadheech@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

/**
 * Dashboard Controller
 *
 * @category  Controllers 
 * @package   App/Controllers
 * @author    Anurag Dadheech <anurag.dadheech@native5.com>
 * @copyright 2014 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 29-04-2014
 * Last Modified : Tue Apr 29 13:11:53 2014
 */

class simulationController extends \Akzo\Control\ProtectedController
// class simulationController extends \Native5\Control\DefaultController
{
    /**
     * _default 
     * 
     * @param mixed $request Request to use
     *
     * @access public
     * @return void
     */
    public function _default($request)
    {
        global $logger;
        $data = array();
        $data['nonce'] = urlencode($GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce'));
        $data["simStatus"] = array(
            "ready" => \Akzo\Scheme\ProcessStatus::READY,
            "partial" => \Akzo\Scheme\ProcessStatus::PARTIAL,
            "locked" => \Akzo\Scheme\ProcessStatus::LOCKED,
            "not_started" => \Akzo\Scheme\ProcessStatus::NOT_STARTED,
            "just_started" => \Akzo\Scheme\ProcessStatus::JUST_STARTED
        );
        $data["WITHOUT_QC"] = Akzo\Scheme\ResultData\GroupType::WITHOUT_QC;
        $data["WITH_QC"] = Akzo\Scheme\ResultData\GroupType::WITH_QC;
        $schemeService = \Akzo\Scheme\Service::getInstance();
        $data['draftSchemes'] = $schemeService->listDraftSchemes($this->user);
        $this->__sendResponse('none', new \Native5\UI\TwigRenderer('simulation.tmpl'), $data);

    }//end _default()

    public function _simulate($request)
    {
        global $logger;
        $data = array();
        $results = array();

        // Request Parameters
        $groups = $request->getParam('groups');
        $actuals = $request->getParam('actuals');

        $executionType = \Akzo\Scheme\ExecuteActionDataType::TARGET;
        if ($request->hasParam('actuals') && $request->getParam('actuals') === 'true') {
            $executionType = \Akzo\Scheme\ExecuteActionDataType::ACTUAL;
            $this->logger->info("ACTUALS:: true ");
        }
        // TODO: Send this as parameter from the front-end
        $groupDealersByCreditCode = true; // $request->getParam('groupByCreditCode');

        // Iterate through the scheme groups and collect scheme codes
        $schemes = array();
        if (!empty($groups) && is_array($groups)) {
            foreach ($groups as $groupIdx=>$group) {
                foreach ($group['value'] as $schemeIdx=>$code) {
                    if(!in_array($code, $schemes)){
                        $schemes[] = $code;
                    }
                }
            }
        }

        $simulationResults = $schemeDetails = array();
        foreach ($schemes as $schemeIdx=>$code) {
            // Get simulation / execution status
            $simulationResults[$schemeIdx] = \Akzo\Scheme\Service::getInstance()->getSchemeExecutionResult(
                $code,
                $executionType,
                $groupDealersByCreditCode
            );
            // $this->logger->info("RESULTS: ".PHP_EOL.print_r($simulationResults,1));

            // Get the scheme detai;s
            $schemeDetails[$schemeIdx] = \Akzo\Scheme\Service::getInstance()->getSchemeByCode($code);

            // TODO: Add a check do not need scheme dealers always, only load once
            // Get the scheme dealers
            $simulationResults[$schemeIdx]['dealers'] = \Akzo\Scheme\Service::getInstance()->getSchemeDealers($code, $groupDealersByCreditCode);
        }
        // $this->logger->info("RESULTS: ".PHP_EOL.print_r($simulationResults,1));

        // $data['results'] = $this->__getResults($simulationResults);
        // $this->logger->info("RESULTS: ".PHP_EOL.print_r($simulationResults,1));
        $data['simulation'] = $simulationResults;
        $data['details'] = $schemeDetails;

        // Periods for getting sales / budget data
        $prevPeriod = array(
            'startDate' => date("Y-1-1", strtotime("this year")),
            'endDate' => date("Y-m-t", strtotime("last month"))
        );
        $currPeriod = array(
            'startDate' => date("Y-m-1", strtotime("this month")),
            'endDate' => date("Y-m-d")
        );
        $ovrPeriod = array(
            'startDate' => date("Y-1-1", strtotime("this year")),
            'endDate' => date("Y-m-d")
        );
        $dealerIDs = \Akzo\Geography\Service::getInstance()->getDealerIDsUnderZM($this->user->identity);
        // Plugin Sales Data
        $data['prevSalesData'] = $this->__getSalesData($prevPeriod, $dealerIDs);
        $data['currSalesData'] = $this->__getSalesData($currPeriod, $dealerIDs);
        // $data['ovrSalesData'] = $this->__getSalesData($this->user->identity, $ovrPeriod, $dealerIDs);
        $data['ovrSalesData'] = array(
            "value"=>(string)(floatval($data['prevSalesData']['value']) + floatval($data['currSalesData']['value'])),
            "volume"=>(string)(floatval($data['prevSalesData']['volume']) + floatval($data['currSalesData']['volume']))
        );
        $this->__sendResponse('json', null, $data);
    }

    public function _simulationDump($request)
    {
        global $logger;
        $simResult = array();
        $count = 0;
        $code = $request->getParam('code');
        $uid = $request->getParam('uid');
        $actuals = $request->getParam('actuals');

        $executionType = \Akzo\Scheme\ExecuteActionDataType::TARGET;
        if ($request->hasParam('actuals') && $request->getParam('actuals') === 'true') {
            $executionType = \Akzo\Scheme\ExecuteActionDataType::ACTUAL;
            $this->logger->info("ACTUALS:: true ");
        }
        // TODO: Send this as parameter from the front-end
        $groupDealersByCreditCode = true; // $request->getParam('groupByCreditCode');

        $simulationResult = \Akzo\Scheme\Service::getInstance()->getSchemeExecutionResult(
            $code,
            $executionType,
            $groupDealersByCreditCode
        );

        if ($groupDealersByCreditCode) {
            $titles = array("Serial No.", "Dealer Credit Code");
        } else {
            $titles = array("Serial No.", "Dealer Code");
        }

        $GLOBALS['logger']->info("sidfljgnz/lfkbnsl/xvndkfgndkjfbg;dflkhlsrgjdfkhgndflkgh: :".print_r($simulationResult,1));


        if(isset($simulationResult['cumulatedData']) && isset($simulationResult['newData'])) {

            if (is_array($simulationResult['cumulatedData']['inBills'])) {
                $titles = array_merge( $titles, array_keys($simulationResult['cumulatedData']['inBills']));
            }

            if (is_array($simulationResult['cumulatedData']['ppiOutputs'])) {
                $ppiTitles = array();
                foreach (array_keys($simulationResult['cumulatedData']['ppiOutputs']) as $key => $value) {
                    $ppiTitles[] = $value.'(without QC)';
                    $ppiTitles[] = $value.'(with QC)';
                }
                $titles = array_merge( $titles, $ppiTitles);
            }

            if (is_array($simulationResult['cumulatedData']['priOutputs'])) {
                $priTitles = array();
                foreach (array_keys($simulationResult['cumulatedData']['priOutputs']) as $key => $value) {
                    $priTitles[] = $value.'(without QC)';
                    $priTitles[] = $value.'(with QC)';
                }
                $titles = array_merge( $titles, $priTitles);

            }

            if (is_array($simulationResult['cumulatedData']['slabOutputs'])) {
                $slabTitles = array();
                foreach (array_keys($simulationResult['cumulatedData']['slabOutputs']) as $key => $value) {
                    $slabTitles[] = $value.'(without QC)';
                    $slabTitles[] = $value.'(with QC)';
                }
                
                $titles = array_merge( $titles, $slabTitles);
            }

            if (is_array($simulationResult['cumulatedData']['slabV2Outputs'])) {
                $slabV2Titles = array();
                foreach (array_keys($simulationResult['cumulatedData']['slabV2Outputs']) as $key => $value) {
                    $slabV2Titles[] = $value.'(without QC)';
                    $slabV2Titles[] = $value.'(with QC)';
                }
                $titles = array_merge( $titles, $slabV2Titles);
            }
            
            foreach ($simulationResult['newData'] as $idx=>$data) {
                $simResult[$count] = array();
                array_push($simResult[$count], $count + 1, $idx);
                // $GLOBALS['logger']->info("In Loop: ".$idx.PHP_EOL.print_r($simulationResult['cumulatedData']['inBills'],1));
                if (is_array($simulationResult['cumulatedData']['inBills'])) {
                    foreach ($simulationResult['cumulatedData']['inBills'] as $i=>$d) {
                        
                        if(!isset(json_decode($data, true)['inBills'][$i]['WITHOUT_QC'])) {
                            array_push($simResult[$count], "-");   

                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['inBills'][$i]['WITHOUT_QC']); 
                            // $GLOBALS['logger']->info("Inside the loop Loop: ".print_r($simResult, 1));   
                        }
                    }
                }

                if (is_array($simulationResult['cumulatedData']['ppiOutputs'])) {
                    foreach ($simulationResult['cumulatedData']['ppiOutputs'] as $i=>$d) {
                        if(!isset(json_decode($data, true)['ppiOutputs'][$i]['WITHOUT_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['ppiOutputs'][$i]['WITHOUT_QC']);    
                        }

                        if(!isset(json_decode($data, true)['ppiOutputs'][$i]['WITH_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['ppiOutputs'][$i]['WITH_QC']);    
                        }
                        
                    }
                }

                if (is_array($simulationResult['cumulatedData']['priOutputs'])) {
                    foreach ($simulationResult['cumulatedData']['priOutputs'] as $i=>$d) {
                        if(!isset(json_decode($data, true)['priOutputs'][$i]['WITHOUT_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['priOutputs'][$i]['WITHOUT_QC']);    
                        }

                        if(!isset(json_decode($data, true)['priOutputs'][$i]['WITH_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['priOutputs'][$i]['WITH_QC']);    
                        }
                        
                    }
                }

                if (is_array($simulationResult['cumulatedData']['slabOutputs'])) {
                    foreach ($simulationResult['cumulatedData']['slabOutputs'] as $i=>$d) {
                        if(!isset(json_decode($data, true)['slabOutputs'][$i]['WITHOUT_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['slabOutputs'][$i]['WITHOUT_QC']);    
                        }

                        if(!isset(json_decode($data, true)['slabOutputs'][$i]['WITH_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['slabOutputs'][$i]['WITH_QC']);    
                        }
                        
                    }
                }


                if (is_array($simulationResult['cumulatedData']['slabV2Outputs'])) {
                    foreach ($simulationResult['cumulatedData']['slabV2Outputs'] as $i=>$d) {
                        if(!isset(json_decode($data, true)['slabV2Outputs'][$i]['WITHOUT_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['slabV2Outputs'][$i]['WITHOUT_QC']);    
                        }

                        if(!isset(json_decode($data, true)['slabV2Outputs'][$i]['WITH_QC'])) {
                            array_push($simResult[$count], "-");    
                        }
                        else {
                            array_push($simResult[$count], json_decode($data, true)['slabV2Outputs'][$i]['WITH_QC']);    
                        }
                        
                    }
                }
                $count++;
                // $GLOBALS['logger']->info("simRESULTS: ".PHP_EOL.print_r($simResult[$count-1],1));

            }

        }
            
        // $GLOBALS['logger']->info("simRESULTS: ".PHP_EOL.print_r($titles,1));


        
        
        $dir = "./tmp";
        if(!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir);         
        }
        $file = "$dir/csvdata-".round(microtime(true) * 1000).".csv";

        $fp = fopen($file, 'w');
        fputcsv($fp, $titles);
        foreach ($simResult as $idx=>$res) {
            // $GLOBALS['logger']->info("res ".$idx.": ".print_r($res,1));
            fputcsv($fp, $res);
        }
        fclose($fp);

        $this->_streamFile($file, $uid.".csv");
    
    }

    private function _streamFile($filePath, $fileName = null, $mimeType = "application/octet-stream") {
        if (is_null($fileName))
            $fileName = basename($filePath);


        if (file_exists($filePath)) {
            // $this->logger->info("Got filePath: ".print_r($filePath, 1)." | Got fileName: ".print_r($fileName, 1));
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mimeType);
            header('Content-Disposition: attachment; filename='.$fileName);
            header('Content-Transfer-Encoding: binary');
            header('Expires: -1');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
                       header('Content-Length: ' . filesize($filePath));
            ob_clean();
            flush();
            readfile($filePath);
            exit;
        }
    }

    private function __getSalesData($period, $dealerIDs)
    {
        //$GLOBALS['logger']->info("kjndkgjd: ".PHP_EOL.print_r($dealerIDs,1));
        return \Akzo\Sales\Service::getInstance()->loadSalesDataFromDealerIDs($dealerIDs, $period);
    }

    private function __endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }



}//end class

