<?php
/**
 *  Copyright 2014 Native5. All Rights Reserved
 *
 *  PHP version 5.3+
 *
 * @category  UserManagement 
 * @package   Native5\Server\User
 * @author    Anurag Dadheech <anurag@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Akzo\User;
use \Respect\Validation\Validator as v;

/**
 * Service Akzo User
 *
 * @category Class
 * @package  Akzo\User
 * @author   Anurag Dadheech <anurag.dadheech@native5.com>
 * @license  See attached LICENSE for details
 * @link     http://www.docs.native5.com 
 *
 */
class Service
{
    protected $_dao;
    protected $_logger;

    /**
     * 
     * @var Singleton
     */
    protected static $_instance;

    /**
     * __construct 
     * 
     * @access private
     * @return void
     */
    private function __construct()
    {
        $this->_logger = $GLOBALS['logger'];
        $this->_app = $GLOBALS['app'];
        $this->_dao = new \Akzo\User\DAOImpl();
    }

    /**
     * getInstance 
     * 
     * @access public
     * @return instance
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getUser($username, $subject = null)
    {
        $user = $this->_dao->loadUser(
            $username
        );

        if (!empty($subject)) {
            $user->setSubject($subject);
        }
        return $user;
    }
}

