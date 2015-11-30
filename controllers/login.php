<?php
/**
 *  Copyright 2014 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
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
use Native5\Identity\UsernamePasswordToken;
use Native5\Identity\AuthenticationException;
use Native5\Identity\SecurityUtils;

/**
 * LoginController
 *
 * @category  Controllers 
 * @package   App/Controllers 
 * @author    Anurag Dadheech <anurag.dadheech@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 29-04-2014
 * Last Modified : Tue Apr 29 13:11:53 2014
 */
class LoginController extends DefaultController
{


    /**
     * _default 
     * 
     * @param mixed $request The incoming request 
     *
     * @access public
     * @return void
     */
    public function _default($request)
    {
        global $logger;
        global $app;

        $subject = SecurityUtils::getSubject();
        $logger->debug('Authentication Status '.print_r($subject,1));

        if ($subject->isAuthenticated() === true) {
            $this->_response->redirectTo('dashboard');
        } else {
            $token = new UsernamePasswordToken(
                $request->getParam('username'),
                $request->getParam('password')
            );

            try {
                $subject->login($token);
                $this->_response->redirectTo('dashboard');
            } catch (AuthenticationException $aex) {
                $this->_handleFailedAuthentication($subject, $token, $aex);
            }
        }

    }//end _default()


    /**
     * _handleFailedAuthentication 
     * 
     * @param mixed $subject The subject
     * @param mixed $token   The tokens used to authenticate
     * @param mixed $aex     The exception
     *
     * @access private
     * @return void
     */
    private function _handleFailedAuthentication($subject, $token, $aex)
    {
        global $logger;
        $renderer        = new \Native5\UI\TwigRenderer('login.tmpl');
        $this->_response = new \Native5\Route\HttpResponse('none', $renderer);
        $logger->info('Invalid credentials');
        $this->_response->setBody(
            array('message' => 'Invalid Credentials')
        );

    }//end _handleFailedAuthentication()

}//end class

