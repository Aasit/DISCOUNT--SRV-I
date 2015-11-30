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
 * Notifier
 * 
 * @category  Schemes, Notifications
 * @package   Akzo\Scheme
 * @author    Shamik Datta <barry@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-06-2014
 * Last Modified : Fri Jun 20 13:30:00 2014
 */
class Notifier
{
    const INITIATOR = "INITIATOR";
    const REVIEWER = "REVIEWER";
    const APPROVER = "APPROVER";

    public static function sendNotification(\Akzo\Scheme $scheme, $transition) {
        $transitionName = $transition->getName();

        $templateData = array (
            "scheme" => $scheme,
            "url" => self::_getSiteUrl(),
            "initiatorName" => $scheme->initiator->identity->name,
            "initiatorCode" => $scheme->initiator->identity->code,
            "reviewerName" => $scheme->reviewer->identity->name,
            "reviewerCode" => $scheme->reviewer->identity->code,
            "approverName" => $scheme->approver->identity->name,
            "approverCode" => $scheme->approver->identity->code
        );

        if (strcmp($transitionName, \Akzo\Scheme\StateTransition::INITIATE_CREATED_SCHEME) === 0
            || strcmp($transitionName, \Akzo\Scheme\StateTransition::INITIATE_STAGED_SCHEME) === 0
            || strcmp($transitionName, \Akzo\Scheme\StateTransition::INITIATE_UPDATED_SCHEME) === 0) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "initiated",
                "Scheme Review / Approval Initiated",
                "Initiated, To be Reviewed",
                $templateData,
                array(
                    self::REVIEWER => true
                )
            );
        } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REVIEW_SCHEME) === 0) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "reviewed",
                "Scheme Reviewed",
                "Reviewed, To be Approved",
                $templateData,
                array(
                    self::REVIEWER => true,
                    self::APPROVER => true
                )
            );
        } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::APPROVE_SCHEME) === 0) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "approved",
                "Scheme Approved",
                "Approved",
                $templateData,
                array(
                    self::APPROVER => true
                )
            );
        } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE) === 0
            && in_array(\Akzo\Scheme\State::TO_BE_REVIEWED, $transition->getInitialStates())) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "reviewerRequestedUpdate",
                "Scheme Update Requested by Reviewer",
                "To be Updated",
                $templateData,
                array(
                    self::REVIEWER => true
                )
            );
        } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE) === 0
            && in_array(\Akzo\Scheme\State::TO_BE_APPROVED, $transition->getInitialStates())) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "approverRequestedUpdate",
                "Scheme Update Requested by Approver",
                "To be Updated",
                $templateData,
                array(
                    self::APPROVER => true
                )
            );
        } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::REQUEST_SCHEME_REVIEW) === 0) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "requestedReview",
                "Scheme Review Requested by Approver",
                "To be Reviewed",
                $templateData,
                array(
                    self::REVIEWER => true,
                    self::APPROVER => true
                )
            );
        } else if (strcmp($transitionName, \Akzo\Scheme\StateTransition::EDIT_APPROVED_SCHEME) === 0) {
            $notifications = self::_prepareNotifications(
                $scheme,
                "editApproved",
                "Edition of Approved Scheme by Initiator",
                "To be Updated",
                $templateData,
                array(
                    self::REVIEWER => true,
                    self::APPROVER => true
                )
            );
        }

        // Send the notifications
        foreach($notifications as $idx=>$notification) {
            file_put_contents(getcwd().'/logs/email.'.$idx.'.log', print_r($notification, 1));
            
            $mailService = \Native5\Services\Messaging\NotificationService::instance();
            $mailStatus = $mailService->sendNotification(
                array(\Native5\Services\Messaging\Notifier::TYPE_EMAIL),
                $notification
            );
        }
    }

    // ******** Private Functions Follow ******** //

    private static function _prepareNotifications($scheme, $type, $subject, $status, $templateData, $sendTo = array()) {
        $notifications = array();

        // Add the state to the templateData
        $templateData['status'] = $status;

        // Add comment to the template if present
        $templateData['comment'] = $scheme->getComment();
        
        // Prepare Notification to the initiator
        $notifications[] = self::_renderNotification(
            $scheme->initiator->identity->email,
            $subject,
            "emails/scheme.".$type.".initiator.tmpl",
            $templateData
        );

        // Prepare Notification to the reviewer
        if (isset($sendTo[self::REVIEWER]) && $sendTo[self::REVIEWER]) {
            $notifications[] = self::_renderNotification(
                $scheme->reviewer->identity->email,
                $subject,
                "emails/scheme.".$type.".reviewer.tmpl",
                $templateData
            );
        }

        // Prepare Notification to the approver
        if (isset($sendTo[self::APPROVER]) && $sendTo[self::APPROVER]) {
            $notifications[] = self::_renderNotification(
                $scheme->approver->identity->email,
                $subject,
                "emails/scheme.".$type.".approver.tmpl",
                $templateData
            );
        }

        return $notifications;
    }

    private static function _renderNotification($email, $subject, $template, $templateData) {
        // Send mail to the initiator
        $renderer = new \Native5\UI\TwigRenderer($template);
        return self::_createEmail(
            array($email),
            $subject,
            $renderer->render($templateData)
        );

    }


    private static function _createEmail($receipients, $subject, $body) {
        $email = new \Native5\Services\Messaging\MailMessage;
        $email->setSubject($subject);
        $email->setBody($body);
        $email->setRecipients($receipients);
        return $email;
    }

    private static function _getSiteUrl() {
        $protocol = isset($_SERVER['HTTPS'])?'https://':'http://';
        $host = $_SERVER['HTTP_HOST'];
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }

        return $protocol.$host.'/'.$GLOBALS['app']->getConfiguration()->getApplicationContext();
    }
}

