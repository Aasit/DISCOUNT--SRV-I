<?php
/**
 * Copyright © 2013 Native5
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
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */
namespace Akzo\Control;

/**
 * ProtectedController 
 * 
 * @category  Controllers 
 * @package   App/Controllers
 * @author    Support Native5 <support@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */

abstract class ProtectedController extends \Native5\Control\ProtectedController {
    protected $logger;
    protected $user;

    /**
     * __construct Checks for authenticated access and creates user object
     * 
     * @param mixed $command 
     * @access public
     * @return void
     */
    public function __construct(&$command) {
        $this->logger = $GLOBALS['logger'];

        parent::__construct($command);

        //if (function_exists('xdebug_start_trace'))
            //xdebug_start_trace();
    }

    /**
     * execute Catches exceptions while execution of the controller function
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function execute($request)
    {
        // Set the protected user variable, before controller execution begins
        $this->__setUser();
        $GLOBALS['logger']->info("data::||||".print_r($request,1));

        // Catch all order related exceptions here
        try {
            parent::execute($request);
        } catch (\Exception $_e) {
            $GLOBALS['logger']->error("Exception in class [ ".get_class($this)." ] : ".$_e->getMessage());
            $this->_response->sendError($_e->getMessage(), 400);
        }

    }

    /**
     * _handleUnauthorizedAccess 
     * 
     * @param $service Service endpoint path
     * @access protected
     * @return void
     */
    protected function _handleUnauthorizedAccess($service = 'dashboard') {
        $this->__checkAjaxForResponse($service);
    }

    /**
     * _handleUnauthenticatedAccess 
     * 
     * @access protected
     * @return void
     */
    protected function _handleUnauthenticatedAccess($service = 'home') {
        $this->__checkAjaxForResponse($service);
    }

    protected function __checkAjaxForResponse($service) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->__sendResponse('json', null, array('__redirect' => $service));
        } else {
            $this->__createResponse(null, 'none');
            $this->_response->redirectTo($service);
        }
    }

    protected function __sendResponse($encoding = 'none', $renderer = null, $renderData = array())
    {
        $this->_response = new \Native5\Route\HttpResponse($encoding, $renderer);
        $this->_response->addHeader('Cache-Control: no-cache, must-revalidate');
        $this->_response->setBody($renderData);
    }

    protected function __createResponse($encoding = 'none', $renderer = null) {
        $this->_response = new \Native5\Route\HttpResponse($encoding, $renderer);
        $this->_response->addHeader('Cache-Control: no-cache, must-revalidate');
    }

    // ****** Private Functions Follow ****** //

    private function __setUser() {
        // Create the (helper) user object from the authenticated subject if present
        $subject = \Native5\Identity\SecurityUtils::getSubject();
        if ($subject->isAuthenticated()) {
            $this->user = \Akzo\User\Service::getInstance()->getUser(
                $subject->getPrincipal()['username'],
                $subject
            );
        }
    }
}

