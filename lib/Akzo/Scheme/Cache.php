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
 * ExecService
 * 
 * @category  Schemes
 * @category  Caching
 * @package   Akzo\Scheme
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-06-2014
 * Last Modified : Fri Jun 20 13:30:00 2014
 */
class Cache {
    //const KEY_NAMESPACE = 'scheme';
    //const SEPARATOR = ':';

    /**
     * 
     * @var Singleton
     */
    private static $_instance;

    protected $con;

    /**
     * __construct 
     * 
     * @access private
     * @return void
     */
    private function __construct() {
        $this->logger = $GLOBALS['logger'];
        $this->config = $GLOBALS['app']->getConfiguration()->getRawConfiguration('cache');
        $this->con = new \Predis\Client(array(
            'scheme'                => $this->config['scheme'],
            'host'                  => $this->config['host'],
            'port'                  => $this->config['port'],
            'database'              => $this->config['database'],
            'read_write_timeout'    => $this->config['read_write_timeout']
        ));
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

    //public function exists($code, $type) {
        //return $this->con->exists(
            //self::_formKey($code, $type)
        //);
    //}

    //public function set($code, $type, $object) {
        //$this->con->set(
            //self::_formKey($code, $type),
            //$object
        //);
    //}

    //public function get($code, $type) {
        //return $this->con->get(
            //self::_formKey($code, $type)
        //);
    //}

    //public function addToList($code, $type, $object) {
        //return $this->con->rpush(
            //self::_formKey($code, $type),
            //$object
        //);
    //}

    //public function getList($code, $type, $offset = 0) {
        //// Return whole list
        //return $this->con->lrange(
            //self::_formKey($code, $type),
            //$offset,
            //$this->con->llen(
                //self::_formKey($code, $type)
            //)
        //);
    //}

    //public function delete($code, $type) {
        //if($this->con->exists(
            //self::_formKey($code, $type)
        //))
        //{
            //$this->con->del(
                //self::_formKey($code, $type)
            //);
        //}
    //}

    public function keyExists($key) {
        return $this->con->exists($key);
    }

    public function listKeys($pattern) {
        return $this->con->keys($pattern);
    }

    public function getValue($key) {
        if ($this->keyExists($key)) {
            return $this->con->get($key);
        }

        return null;
    }

    public function setValue($key, $value) {
        return $this->con->set($key, $value);
    }

    public function deleteKey($key) {
        if ($this->keyExists($key)) {
            return $this->con->del($key);
        }

        return true;
    }

    public function getMap($key) {
        if ($this->keyExists($key)) {
            return $this->con->hgetall($key);
        }

        return null;
    }

    public function setMap($key, $mapArray) {
        return $this->con->hmset($key, $mapArray);
    }

    public function getMapAttribute($key, $attrKey) {
        if ($this->keyExists($key)) {
            return $this->con->hget($key, $attrKey);
        }

        return null;
    }

    public function setMapAttribute($key, $attrKey, $attrVal) {
        return $this->con->hset($key, $attrKey, $attrVal);
    }

    //private static function _formKey($code, $type) {
        //if (strcmp($type, \Akzo\Scheme\CacheKeyType::SIMULATION_STATUS) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::SIMULATION_STATUS;
        //} else if (strcmp($type, \Akzo\Scheme\CacheKeyType::SIMULATION_RESULT) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::SIMULATION_RESULT;
        //} else if (strcmp($type, \Akzo\Scheme\CacheKeyType::SIMULATION_RESULT_NEW) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::SIMULATION_RESULT_NEW;
        //} else if (strcmp($type, \Akzo\Scheme\CacheKeyType::SIMULATION_CUMULATED_RESULT) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::SIMULATION_CUMULATED_RESULT;
        //} else if (strcmp($type, \Akzo\Scheme\CacheKeyType::EXECUTION_STATUS) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::EXECUTION_STATUS;
        //} else if (strcmp($type, \Akzo\Scheme\CacheKeyType::EXECUTION_RESULT) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::EXECUTION_RESULT;
        //} else if (strcmp($type, \Akzo\Scheme\CacheKeyType::EXECUTION_CUMULATED_RESULT) === 0) {
            //return self::KEY_NAMESPACE
                //.self::SEPARATOR.$code
                //.self::SEPARATOR.\Akzo\Scheme\CacheKeyType::EXECUTION_CUMULATED_RESULT;
        //} else {
            //throw new \InvalidArgumentException(
                //"Unsupported cache key",
                //\Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
            //);
        //}
    //}
}
