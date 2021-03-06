<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *  PHP version 5.3+
 *
 * @category  <category> 
 * @package   Native5\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Services\Messaging;

use Native5\Services\Messaging\Message;

/**
 * SMSMessage 
 * 
 * @category  Notifications 
 * @package   Native5\Services\Messaging
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class SMSMessage implements Message
{

    private $_senderNumber;

    private $_receipentNumber;

    private $_message;

    private $_from;

    private $_id;


    /**
     * __construct 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_id = uniqid();

    }//end __construct()


    /**
     * getID 
     * 
     * @access public
     * @return void
     */
    public function getID() {
        return $this->_id;
    }

    public function setSubject($subject) {
        throw new Exception("Function not supported");
    }

    public function getSubject() {
        throw new Exception("Function not supported");
    }

    public function getBody() {
        return $this->_message;	
    }

    public function setBody($body) {
        $this->_message = $body;	
    }

    public function setRecipients($recipients) {
        $this->_senderNumber = $recipients;
    }

    public function getRecipients() {
        return $this->_senderNumber;
    }

    public function setFrom($from) {
        $this->_from = $from;
    }

    public function getFrom() {
        return $this->_from;
    }

}
?>
