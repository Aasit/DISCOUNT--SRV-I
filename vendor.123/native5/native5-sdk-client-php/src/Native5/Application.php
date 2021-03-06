<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *
 *  You may obtain a copy of the License at
 *  http://www.apache.org/licenses/LICENSE-2.0
 *  or in the "license" file accompanying this file.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Application
 * @package   Native5\Application\
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5;

use Native5\Configuration;
use Native5\Route\RoutingEngine;
use Native5\Services\Messaging\NotificationService;

use Native5\Core\Log\LoggerFactory;
use Native5\Core\Log\Logger;

use Native5\Sessions\WebSessionManager;
use Native5\Sessions\Session;

use Native5\Identity\DefaultSubjectContext;
use Native5\Identity\Subject;
use Native5\Identity\DefaultSecurityManager;
use Native5\Identity\SecurityUtils;

/**
 * Application
 *
 * @category  Application
 * @package   Native5\Core
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class Application
{

    private $_services;

    private $_config;

    private $_subject;

    private static $LOG_MAPPING = array(
        'debug'     => 'LOG_DEBUG',
        'info'      => 'LOG_INFO',
        'warning'   => 'LOG_WARNING',
        'error'     => 'LOG_ERR',
        'crit'      => 'LOG_CRIT',
        'alert'     => 'LOG_ALERT',
    );

    private static $_cli;

    /**
     * __construct 
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
        // Read Config file and initialize services.
        $this->_services = array();
    }

    /**
     * init 
     * 
     * @param string $configFile Configuration with which to initialize an app with
     *
     * @static
     * @access public
     * @return void
     */
    public static function init($configFile='config/settings.yml', $localConfigFile='config/settings.local.yml')
    {
        // Check what php SAPI is being used
        self::$_cli = false;
        if (strcmp(php_sapi_name(), 'cli') === 0)
            self::$_cli = true;

        // Initialize application services, Store application Object as a global
        // Services are available from global app.
        $GLOBALS['app']    = $app = new self();
        $GLOBALS['logger'] = LoggerFactory::instance()->getLogger();
        $GLOBALS['routeLogger'] = LoggerFactory::instance()->getLogger();

        $configFactory     = new ConfigurationFactory($configFile, $localConfigFile);
        $app->_config      = $configFactory->getConfig();
        
        $logFolder =  getcwd().'/logs';
        if (!file_exists($logFolder)) {
            if(!mkdir($logFolder)) {
                $logFolder = sys_get_temp_dir().'/logs';
                if(!file_exists($logFolder) && !mkdir($logFolder)) {
                    die('Insufficient privileges to create logs folder in application directory, or temp path, exiting');    
                }
            }
        }

        $file              = $logFolder.DIRECTORY_SEPARATOR.$app->_config->getApplicationContext().'-debug.log';
        $GLOBALS['logger']->addHandler($file, Logger::ALL, self::$LOG_MAPPING[$app->_config->getLogLevel()]);

        $analyticsFile = $logFolder.DIRECTORY_SEPARATOR.$app->_config->getApplicationContext().'-analytics.log';
        $GLOBALS['routeLogger']->addHandler($analyticsFile, Logger::ALL, self::$LOG_MAPPING[$app->_config->getLogLevel()], 'analytics');

        if (!self::$_cli) {
            $sessionManager = new WebSessionManager();
            $sessionManager->startSession(null, true);
            $app->_services['sessions']   = $sessionManager;

            SecurityUtils::setSecurityManager(new DefaultSecurityManager());

            $app->_subject = $app->_getSubjectFromSession($sessionManager->getActiveSession());

            $app->_services['routing']    = new RoutingEngine();
        }

        $app->_services['messaging']  = NotificationService::instance();

        return $app;
    }

    /**
     * getSubject 
     * 
     * @access public
     * @return Subject  
     */
    public function getSubject()
    {
        if (!self::$_cli)
            return $this->_subject;
        else
            return null;
    }

    /**
     * setSubject 
     * 
     * @param mixed $subject Currently active subject.
     *
     * @access public
     * @return void
     */
    public function setSubject($subject)
    {
        if (!self::$_cli)
            $this->_subject = $subject;
    }

    /**
     * getSessionManager 
     * 
     * @access public
     * @return SessionManager 
     */
    public function getSessionManager()
    {
        if (!self::$_cli)
            return $this->_services['sessions'];
        else
            return null;
    }

    /**
     * getConfiguration Get configuration of the application.  
     * 
     * @access public
     * @return void
     */
    public function getConfiguration()
    {
        return $this->_config;
    }

    /**
     * get 
     * 
     * @param mixed $serviceName Service to find
     *
     * @access public
     * @return Service
     * @throws \Exception Service not found 
     */
    public function get($serviceName)
    {
        $service = $this->_services[$serviceName];
        if (empty($service) === false) {
            return $service;
        }

        throw new \Exception('Service '.$serviceName.' not defined');
    }

    /**
     * isDebugMode 
     * 
     * @access public
     * @return void
     */
    public function isDebugMode()
    {
        global $app;
        return true;
    }

    /**
     * Handles routing for all incoming requests. 
     * 
     * @param mixed $request Route the application based on incoming request.
     *
     * @access public
     * @return void
     */
    public function route($request)
    {
        if (!self::$_cli) {
            $router = $this->get('routing');
            $router->route($request);
        }
    }


    /**
     * getSubjectFromSession 
     * 
     * @param Session $session The currently active session. 
     *
     * @access private
     * @return Subject 
     */
    private function _getSubjectFromSession(Session $session)
    {
        $subject = Subject::createBuilder()
            ->principals($session->getAttribute(DefaultSubjectContext::PRINCIPALS_SESSION_KEY))
            ->authenticated($session->getAttribute(DefaultSubjectContext::AUTHENTICATED_SESSION_KEY))
            ->authorization($session->getAttribute(DefaultSubjectContext::AUTHORIZATION_SESSION_KEY))
            ->session($session)
            ->build();
        return $subject;
    }
}

