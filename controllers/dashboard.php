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

class dashboardController extends \Akzo\Control\ProtectedController
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

        $data['stats'] = $this->_getSchemeStats(false);
        //$data['states'] = $this->_getSchemeStates(false);
        $data["badges"] = $this->_getBadgeData(false);
        $data["concludedSchemes"] = $this->_getConcludedData(false);
        $data["notifications"] = $this->_getNotificationData(false);
        $data["graphdata"] = $this->_getSchemeGraph(false);
        
        $this->__sendResponse('none', new \Native5\UI\TwigRenderer('dashboard.tmpl'), $data);

    }//end _default()

    public function testEmail() {
        $channels = array();
        $channels[] = \Native5\Services\Messaging\Notifier::TYPE_EMAIL;
        $email = new \Native5\Services\Messaging\MailMessage;

        $email->setSubject('Test E-mail : Subject 001');
        $email->setBody('Testing E-mail Sending works.');
        $email->setRecipients(array('shamik@native5.com', 'ravi.kishore@native5.com'));
        //$email->addAttachment(__FILE__);
        //$email->addAttachment(__DIR__.'/../../Application.php');
        //$email->addAttachment('/home/shamik/Work/Native5_Packages/SDKs/native5-sdk-services-php/LICENSE');
        //$email->addAttachment('/home/shamik/Work/Native5_Packages/SDKs/native5-sdk-services-php/VERSION');

        $mailService = \Native5\Services\Messaging\NotificationService::instance();
        $mailStatus = $mailService->sendNotification($channels, $email);
        $GLOBALS['logger']->info("Got mailStatus: ".print_r($mailStatus, 1));
    }

    // ****** Private Function Follow ****** //

    private function _loadOrder($orderCode) {
        $stagingDS = StagingDataStore::instance();
        $DAO = new OrderDAO();
        
        if (empty($orderCode))
            throw new \Akzo\Error\OrderException("Empty order code received");
            
        // First try loading order from staging datastore
        if ($stagingDS->isOrderInStore($orderCode))
            $order =  $stagingDS->getOrder($orderCode);
        else
            // If not found, check in database
            $order = $DAO->loadOrder($orderCode);

        if (empty($order))
            throw new \Akzo\Error\OrderException("Order could not be found");

        $this->_order = $order;
    }
    public function _getSchemeStats($render = true)
    {
        $schemeService = \Akzo\Scheme\Service::getInstance();
        $schemesInitiatedCount = count($schemeService->getSchemesInitiated($this->user));
        $schemeSpendingCount= count($schemeService->getSchemesPendingApproval($this->user));
        $schemeConcludedCount= count($schemeService->getSchemesConcluded($this->user));
        $data = array();
        $data["initiated"] = $schemesInitiatedCount;
        $data["pending"] = $schemeSpendingCount;
        $data["concluded"] = $schemeConcludedCount;
        $data["active"] = 38;
        
        if ($render)
            $this->__sendResponse('json', null, $data);
        else
            return $data;
    }

    public function _getBadgeData($render = true)
    {
        $data = array();

        array_push($data, array("title" => "PPI/PRI", "estimate" => 70000, "forcast" => 100000, "percent" => 35));
        array_push($data, array("title" => "Club Spend", "estimate" => 10000, "forcast" => 270000, "percent" => 27));
        array_push($data, array("title" => "ATR + QTR Spend", "estimate" => 5000, "forcast" => 10000, "percent" => 50));
        array_push($data, array("title" => "Monthly", "estimate" => 100000, "forcast" => 90000, "percent" => 109));
        array_push($data, array("title" => "Tie Up", "estimate" => 40000, "forcast" => 20000, "percent" => 200));
        array_push($data, array("title" => "Inbill", "estimate" => 70000, "forcast" => 100000, "percent" => 70));
        array_push($data, array("title" => "Scheme Outage", "estimate" => 80000, "forcast" => 100000, "percent" => 80));
        array_push($data, array("title" => "PPIPRI", "estimate" => 70000, "forcast" => 100000, "percent" => 35));

        if ($render)
            $this->__sendResponse('json', null, $data);
        else
            return $data;
    }

     public function _getConcludedData($render = true)
    {
        $data = array();

        array_push($data, array("title" => "Scheme Name 001", "notification" => "Notification received from Mr. A", "startDate" => "10 Aug 2015", "endDate" => "20 Dec 2015", "forcast" => 10,000,000, "initiatedOn" => "19 Sept 2013", "initiatedBy" => "Mr. S", "reviewedOn" => "21 Sept 2013", "reviewedBy" => "Mr. D", "Status" => "Reviewed"));
        array_push($data, array("title" => "Scheme Name 002", "notification" => "Notification received from Mr. A", "startDate" => "10 Aug 2015", "endDate" => "20 Dec 2015", "forcast" => 10,000,000, "initiatedOn" => "19 Sept 2013", "initiatedBy" => "Mr. S", "reviewedOn" => "21 Sept 2013", "reviewedBy" => "Mr. D", "Status" => "Initiated"));
        array_push($data, array("title" => "Scheme Name 003", "notification" => "Notification received from Mr. A", "startDate" => "10 Aug 2015", "endDate" => "20 Dec 2015", "forcast" => 10,000,000, "initiatedOn" => "19 Sept 2013", "initiatedBy" => "Mr. S", "reviewedOn" => "21 Sept 2013", "reviewedBy" => "Mr. D", "Status" => "Completed"));
        array_push($data, array("title" => "Scheme Name 001", "notification" => "Notification received from Mr. A", "startDate" => "10 Aug 2015", "endDate" => "20 Dec 2015", "forcast" => 10,000,000, "initiatedOn" => "19 Sept 2013", "initiatedBy" => "Mr. S", "reviewedOn" => "21 Sept 2013", "reviewedBy" => "Mr. D", "Status" => "Approved"));
        array_push($data, array("title" => "Scheme Name 001", "notification" => "Notification received from Mr. A", "startDate" => "10 Aug 2015", "endDate" => "20 Dec 2015", "forcast" => 10,000,000, "initiatedOn" => "19 Sept 2013", "initiatedBy" => "Mr. S", "reviewedOn" => "21 Sept 2013", "reviewedBy" => "Mr. D", "Status" => "Reviewed"));
        if ($render)
            $this->__sendResponse('json', null, $data);
        else
            return $data;
    }

    public function _getNotificationData($render = true)
    {
        $data = array();

        $data = array (
            array (
                'messageType' => 'notification',
                'textStr' => 'You got a notification',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'warning',
                'textStr' => 'Attention Needed',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'notification',
                'textStr' => 'You got a notification',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'success',
                'textStr' => 'New Comment',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'notification',
                'textStr' => 'You got a notification',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'success',
                'textStr' => 'New Comment',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'success',
                'textStr' => 'New Comment',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'notification',
                'textStr' => 'You got a notification',
                'subtextStr' => '2 Minutes Ago',
            ),
            array (
                'messageType' => 'warning',
                'textStr' => 'Attention Needed',
                'subtextStr' => '2 Minutes Ago',
            ),
        );

        if ($render)
            $this->__sendResponse('json', null, $data);
        else
            return $data;
    }

    public function _getSchemeGraph($render = true)
    {
        $data = array();

        $data = array (
            'containerId' => 'active-scheme-content',
            'dataSeries' =>
            array(array(7, 7, 5, 6, 7,7, 7, 5, 6, 7), array(3, 2, 2, 3, 8,7, 7, 5, 6, 7)),
            'statusSeries' =>
            array("ex","po","ex","po", "po","ex","po","ex","po", "po"),
            'tickyaxislabel' =>
            array("Deshable", "Schedule", "thunder", "cloud", "Deshable", "Schedule", "thunder", "cloud", "thunder", "cloud"),
        );

        if ($render)
            $this->__sendResponse('json', null, $data);
        else
            return $data;
    }

    public function _getSchemeStates($render = true)
    {
        $data = array();
        $schemeService = \Akzo\Scheme\Service::getInstance();
        $schemesPendingApproval = $schemeService->getSchemesPendingApproval($this->user);
        $data['schemesPendingApproval'] = $schemesPendingApproval;
        // $data['schemesPendingApproval'] = array_slice($schemesPendingApproval, 0, 10);
        $data['states'] = array(
            "staged" => \Akzo\Scheme\State::STAGED, 
            "initiated" => \Akzo\Scheme\State::TO_BE_REVIEWED, 
            "reviewed" => \Akzo\Scheme\State::TO_BE_APPROVED, 
            "approved" => \Akzo\Scheme\State::APPROVED,
            "updateRequested" => \Akzo\Scheme\State::UPDATE_REQUESTED
        );
        $data['nonce'] = urlencode($GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce'));
        file_put_contents(getcwd().'/logs/schemes.log', "schemes: ".PHP_EOL.print_r($data['schemesPendingApproval'],1));
        $this->__sendResponse('json', new \Native5\UI\TwigRenderer('schemeDetails.tmpl'), $data);
    }

}//end class

