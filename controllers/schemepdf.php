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

class schemepdfController extends \Akzo\Control\ProtectedController
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

        $dealers = array(
                array(
                    "name" => "<>",
                    "code" => "<>",
                    "address" => "<>"
                )
            );

        $data['dealers'] = $dealers;

        $this->__sendResponse('none', new \Native5\UI\TwigRenderer('schemePDF.tmpl'), $data);

    }//end _default()


}//end class

