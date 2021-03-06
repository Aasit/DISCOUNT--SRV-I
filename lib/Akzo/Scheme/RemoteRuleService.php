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
 * @category  Rules, Schemes
 * @package   Akzo\Scheme
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Akzo\Scheme;


/**
 * Service
 * 
 * @category  Schemes
 * @package   Akzo\Scheme
 * @author    Shamik Datta <barry@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-06-2014
 * Last Modified : Fri Jun 20 13:30:00 2014
 */
class RemoteRuleService extends \Native5\Services\Common\ApiClient
{
    protected static $BASE_URL = 'scheme';

    protected $logger;
    protected $apiUrl;

    /**
     * __construct 
     * 
     * @access private
     * @return void
     */
    public function __construct($key=null, $secret=null, $url=null) {
        $this->apiUrl = $GLOBALS['app']->getConfiguration()->getRawConfiguration('scheme')['ruleApiUrl'];
        parent::__construct(null, null, $this->apiUrl);
        $this->_logger = $GLOBALS['logger'];
    }

    /**
     * createScheme Create a rule for a discount scheme
     * 
     * @param string $schemeJson JSON string with the scheme structure
     * @access public
     * @return string Scheme Id returned by rule engine
     */
    public function createScheme($schemeJson) {
        $path = self::$BASE_URL.'/create';
        $request = $this->_remoteServer->post(
            $path,
            array('Content-Type'=>'application/json'),
            $schemeJson
        );

        try {
            $response = $request->send();
        } catch(\Guzzle\Http\Exception\BadResponseException $e) {
            $logger->info($e->getResponse()->getBody('true'), array());
            return false;
        }

        // Return the scheme ID generated by the rule engine
        return $response->getBody('true'); 
    }

    /**
     * updateScheme Update a rule for a discount scheme
     * 
     * @param string $schemeId Scheme Id
     * @param string $schemeJson JSON string with the scheme structure
     * @access public
     * @return string Scheme Id returned by rule engine
     */
    public function updateScheme($schemeId, $schemeJson) {
        $path = self::$BASE_URL.'/update/'.$schemeId;

        $request = $this->_remoteServer->put(
            $path,
            array('Content-Type'=>'application/json'),
            $schemeJson
        );

        try {
            $response = $request->send();
        } catch(\Guzzle\Http\Exception\BadResponseException $e) {
            $logger->info($e->getResponse()->getBody('true'), array());
            return false;
        }

        // Return the scheme ID generated by the rule engine
        return $response->getBody('true'); 
    }

    /**
     * deleteScheme Delete a rule for a discount scheme
     * 
     * @param string $schemeId Scheme Id
     * @param string $schemeJson JSON string with the scheme structure
     * @access public
     * @return string Scheme Id returned by rule engine
     */
    public function deleteScheme($schemeId) {
        $path = self::$BASE_URL.'/delete/'.$schemeId;

        $request = $this->_remoteServer->delete(
            $path
        );

        try {
            $response = $request->send();
        } catch(\Guzzle\Http\Exception\BadResponseException $e) {
            $logger->info($e->getResponse()->getBody('true'), array());
            return false;
        }

        // Return the scheme ID returned by the rule engine
        return $response->getBody('true'); 
    }

    /**
     * executeScheme Execute a rule for a discount scheme
     * 
     * @param string $schemeId Scheme Id
     * @param string $schemeExecJson JSON string with the scheme structure
     * @access public
     * @return string Scheme Id returned by rule engine
     */
    public function executeScheme($schemeId, $schemeExecJson) {
        $path = self::$BASE_URL.'/execute/'.$schemeId;

        $request = $this->_remoteServer->post(
            $path,
            array('Content-Type'=>'application/json'),
            $schemeExecJson
        );

        try {
            $response = $request->send();
        } catch(\Guzzle\Http\Exception\BadResponseException $e) {
            $logger->info($e->getResponse()->getBody('true'), array());
            return false;
        }

        // Return the scheme ID returned by the rule engine
        return $response->getBody('true'); 
    }
}

