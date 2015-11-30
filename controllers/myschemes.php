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

class myschemesController extends \Akzo\Control\ProtectedController
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
        //$this->testEmail();
        global $logger;
        $data = array();
        $schemeService = \Akzo\Scheme\Service::getInstance();
        $data['schemesPendingApproval'] = $schemeService->getSchemesPendingApproval($this->user);
        $data['initiatedSchemes'] = $schemeService->listInitiatedSchemes($this->user);
        $data['toBeReviewedSchemes'] = $schemeService->listToBeReviewedSchemes($this->user);
        $data['toBeApprovedSchemes'] = $schemeService->listToBeApprovedSchemes($this->user);
        $data['draftSchemes'] = $schemeService->listDraftSchemes($this->user);
        // $data['schemesPendingApproval'] = array_slice($schemesPendingApproval, 0, 10);
        $data['states'] = array(
            "staged" => \Akzo\Scheme\State::STAGED, 
            "initiated" => \Akzo\Scheme\State::TO_BE_REVIEWED, 
            "reviewed" => \Akzo\Scheme\State::TO_BE_APPROVED, 
            "approved" => \Akzo\Scheme\State::APPROVED,
            "updateRequested" => \Akzo\Scheme\State::UPDATE_REQUESTED
        );
        $data['nonce'] = urlencode($GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce'));
        //$GLOBALS['logger']->info("SChemes: ".PHP_EOL.print_r($data,1));


        $this->__sendResponse('none', new \Native5\UI\TwigRenderer('mySchemes.tmpl'), $data);

    }//end _default()

}//end class

