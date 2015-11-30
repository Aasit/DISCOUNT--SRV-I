<?php
/**
 * Copyright © 2014 Native5
 *
 * All Rights Reserved.
 * Licensed under the Native5 License, Version 1.0 (the 'License');
 * You may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.native5.com/legal/npl-v1.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
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

use Native5\Control\DefaultController;
use Native5\Route\HttpResponse;
use Native5\UI\TwigRenderer;

/**
 * Home Controller
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
class schemeController extends \Akzo\Control\ProtectedController
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
        $data['segmentTypes'] = array(
            "1"=> "70 Trade",
            "4"=> "76 Direct",
            "990"=> "76 RS", 
            "991"=> "76 Sub Dealer", 
            "992"=> "77 MR Bharat", 
            "5"=> "77 MR Trade",
            "3"=> "74 Professional"
        );
        $data['qcBasevalue'] = array(
            "HISTORICAL VALUE"=>"Historical Value",
            "HISTORICAL VOLUME"=>"Historical Volume",
            "TARGET VALUE"=>"Target Value",
            "TARGET VOLUME"=>"Target Volume",
            "GROWTH VALUE"=>"Value Growth",
            "GROWTH VOLUME"=>"Volume Growth",
            "ACTUAL VALUE"=>"Actual Value",
            "ACTUAL VOLUME"=>"Actual Volume",
            "TARGET_ACHIEVEMENT VALUE"=>"Value Target Achievement",
            "TARGET_ACHIEVEMENT VOLUME"=>"Volume Target Achievement",
            "RATIO VALUE"=>"Value Ratio ",
            "RATIO VOLUME"=>"Volume Ratio"
        );
        $data['qcOperator'] = array(
            "GREATER_THAN_EQUALS"=>"Greater Than or Equal to",
            "LESS_THAN"=>"Less than"
        );
        $data["defaultStates"] = array(
            "staged" => \Akzo\Scheme\State::STAGED,
            "updateRequested" => \Akzo\Scheme\State::UPDATE_REQUESTED,
            "initiated" => \Akzo\Scheme\State::TO_BE_REVIEWED,
            "reviewed" => \Akzo\Scheme\State::TO_BE_APPROVED,
            "approved" => \Akzo\Scheme\State::APPROVED
        );
        
        $data['nonce'] = urlencode($GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce'));
        $schemeId = $request->getParam("schemeId");

        if (!empty($schemeId) ) {
            // TODO: Fix this hack of checking for scheme
            $scheme = \Akzo\Scheme\Service::getInstance()->getInitiatedScheme(
                $this->user,
                $schemeId
            );
            $data['userType'] = "initiator";
            if (empty($scheme)) {
                $scheme = \Akzo\Scheme\Service::getInstance()->getToBeReviewedScheme(
                    $this->user,
                    $schemeId
                );
                $data['userType'] = "reviewer";
            }
            if (empty($scheme)) {
                $scheme = \Akzo\Scheme\Service::getInstance()->getToBeApprovedScheme(
                    $this->user,
                    $schemeId
                );
                $data['userType'] = "approver";
            }
            $data["schemeDataRaw"] = $scheme->data;
            $data["schemeData"] = json_decode($scheme->data, 1);
            // $this->logger->info("Scheme default: " . print_r($data['schemeData'], 1));
            $data["state"] = $scheme->state;
            $data["schemeCode"] = $scheme->code;
        }
        else{
            $data['userType'] = "creator";
        }

        $this->__sendResponse('none', new \Native5\UI\TwigRenderer('scheme.tmpl'), $data);
    }//end _default()

    /**
     * _generatePDF
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _generatePDF($request)
    {
        global $logger;
        $schemeId = $request->getParam('schemeId');
        $generateDir = __DIR__ .'/../pdf';

        $schemeService = \Akzo\Scheme\Service::getInstance();

        $path = $schemeService->generatePDF($schemeId, $generateDir);

        if(file_exists($path)) {
            $this->_streamFile($path);
        }
    }

    /**
     * _getDealerWisePDFs
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    // TODO: Make following function to zip the created PDF and stream.
    public function _downloadDealerWisePDFs($request)
    {
        global $logger;
        $schemeId = $request->getParam('schemeId');
        $generateDir = __DIR__ .'/../pdf';

        $schemeService = \Akzo\Scheme\Service::getInstance();
        
        list($files, $uid) = $schemeService->getGeneratedPDFs($schemeId, $generateDir);

        $zip = new ZipArchive();
        $filename = $generateDir . "/" . $uid . ".zip";

        if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
            exit("cannot open <$filename>\n");
        }

        if(!empty($files)) {
            foreach ($files as $key => $file) {
                $zip->addFile($file, basename($file));
            }
        } else {
            $zip->addFromString('ERROR.md', 'No PDF found');
        }

        $zip->close();

        $this->_streamFile($filename);
    }

    private function _streamFile($filePath, $fileName = null, $mimeType = "application/octet-stream")
    {
        if (is_null($fileName))
            $fileName = basename($filePath);


        if (file_exists($filePath)) {
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
            unlink($filePath);
            exit;
        }
    }
}
