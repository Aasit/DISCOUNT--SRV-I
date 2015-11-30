<?php
/**
 * Copyright © 2014 Native5
 *
 * All Rights Reserved.
 * Licensed under the Native5 License, Version 1.0 (the 'License');
 * You may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.native5.com/legal/npl-v1.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
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

use Native5\Control\DefaultController;
use Native5\Route\HttpResponse;
use Native5\UI\TwigRenderer;

/**
 * Home Controller
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
class templateController extends \Akzo\Control\ProtectedController
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
        $data['nonce'] = urlencode($GLOBALS['app']->getSessionManager()->getActiveSession()->getAttribute('nonce'));
        $data['qcBasevalue'] = array(
            array('textStr'=> "Historical Value", 'attr'=> array('name'=> "value", 'value'=> "Historical Value")),
            array('textStr'=> "Historical Volume", 'attr'=> array('name'=> "value", 'value'=> "Historical Volume")),
            array('textStr'=> "Target Value", 'attr'=> array('name'=> "value", 'value'=> "Target Value")),
            array('textStr'=> "Target Volume", 'attr'=> array('name'=> "value", 'value'=> "Target Volume")),
            array('textStr'=> "Value Growth", 'attr'=> array('name'=> "value", 'value'=> "Growth Value")),
            array('textStr'=> "Volume Growth", 'attr'=> array('name'=> "value", 'value'=> "Growth Volume")),
            array('textStr'=> "Actual Value", 'attr'=> array('name'=> "value", 'value'=> "Actual Value")),
            array('textStr'=> "Actual Volume", 'attr'=> array('name'=> "value", 'value'=> "Actual Volume")),
            array('textStr'=> "Value Target Achievement", 'attr'=> array('name'=> "value", 'value'=> "Target_Achievement Value")),
            array('textStr'=> "Volume Target Achievement", 'attr'=> array('name'=> "value", 'value'=> "Target_Achievement Volume")),
            array('textStr'=> "Value Ratio ", 'attr'=> array('name'=> "value", 'value'=> "Ratio Value")),
            array('textStr'=> "Volume Ratio", 'attr'=> array('name'=> "value", 'value'=> "Ratio Volume"))
        );

        $data['qcOperator'] = array(
            array('textStr'=> "Greater Than or Equal to", 'attr'=> array('name'=> "value", 'value'=> "GREATER_THAN_EQUALS")),
            array('textStr'=> "Less than", 'attr'=> array('name'=> "value", 'value'=> "LESS_THAN"))
        );

        $data['schemeTypes'] = array(
            array('textStr'=> 'Monthly', 'attr'=> array('name'=> 'value', 'value'=> 'sch1')),
            array('textStr'=> 'ATR', 'attr'=> array('name'=> 'value', 'value'=> 'sch2')),
            array('textStr'=> 'QTR', 'attr'=> array('name'=> 'value', 'value'=> 'sch3')),
            array('textStr'=> 'Custom Scheme', 'attr'=> array('name'=> 'value', 'value'=> 'sch4'))
        );

        // TODO: Read value from ak_sales_verticals table `id` column
        $data['segmentTypes'] = array(
            array('textStr'=> "70 Trade", "attr"=> array("name"=> "value", "value"=> "70 Trade")),
            array('textStr'=> "76 Direct", "attr"=> array("name"=> "value", "value"=> "76 Direct")),
            array('textStr'=> "76 RS", "attr"=> array("name"=> "value", "value"=> "76 RS")),
            array('textStr'=> "76 Sub Dealer", "attr"=> array("name"=> "value", "value"=> "76 Sub Dealer")),
            array('textStr'=> "77 MR Bharat", "attr"=> array("name"=> "value", "value"=> "77 MR Bharat")),
            array('textStr'=> "77 MR Trade", "attr"=> array("name"=> "value", "value"=> "77 MR Trade")),
            array('textStr'=> "74 Professional", "attr"=> array("name"=> "value", "value"=> "74 Professional"))
        );

        $data['dealerTypes'] = array(
            array('name'=>"Segmentation", 'value'=> "segmentation", 'children'=>array(
                    array('textStr'=> "CSSB1", "attr"=> array("name"=> "value", "value"=> "CSSB1")),
                    array('textStr'=> "CSSB2", "attr"=> array("name"=> "value", "value"=> "CSSB2")),
                    array('textStr'=> "Distributor", "attr"=> array("name"=> "value", "value"=> "Distributor")),
                    array('textStr'=> "Dulux Point", "attr"=> array("name"=> "value", "value"=> "Dulux Point")),
                    array('textStr'=> "Gold", "attr"=> array("name"=> "value", "value"=> "Gold")),
                    array('textStr'=> "Others", "attr"=> array("name"=> "value", "value"=> "Others")),
                    array('textStr'=> "Platinum", "attr"=> array("name"=> "value", "value"=> "Platinum")),
                    array('textStr'=> "POS1", "attr"=> array("name"=> "value", "value"=> "POS1")),
                    array('textStr'=> "POS2", "attr"=> array("name"=> "value", "value"=> "POS2")),
                    array('textStr'=> "POS3", "attr"=> array("name"=> "value", "value"=> "POS3")),
                    array('textStr'=> "Professional NKA", "attr"=> array("name"=> "value", "value"=> "Professional NKA")),
                    array('textStr'=> "Silver", "attr"=> array("name"=> "value", "value"=> "Silver")),
                    array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN00 Not assigned"))
                )
            ),
            array('name'=>"CSS Type", 'value'=> "css_type", 'children'=>array(
                    array('textStr'=> "CSS - Automatic", "attr"=> array("name"=> "value", "value"=> "CSS - Automatic")),
                    array('textStr'=> "CSS - Manual", "attr"=> array("name"=> "value", "value"=> "CSS - Manual")),
                    array('textStr'=> "DCC", "attr"=> array("name"=> "value", "value"=> "DCC")),
                    array('textStr'=> "Non CSS", "attr"=> array("name"=> "value", "value"=> "Non CSS")),
                    array('textStr'=> "Non-DCC", "attr"=> array("name"=> "value", "value"=> "Non-DCC")),
                    array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN00 Not assigned"))
                )
            ),
            array('name'=>"Dealer Type", 'value'=> "dealer_type", 'children'=>array(
                    array('textStr'=> "ANI Exclusive", "attr"=> array("name"=> "value", "value"=> "ANI Exclusive")),
                    array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN00 Not assigned")),
                )
            ),
            array('name'=>"Town Tier", 'value'=> "town_tier", 'children'=>array(
                    array('textStr'=> "Developer", "attr"=> array("name"=> "value", "value"=> "Developer")),
                    array('textStr'=> "Non-Developer", "attr"=> array("name"=> "value", "value"=> "Non Developer")),
                    array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN00 Not assigned")),
                )
            ),
            array('name'=>"Tie Up Type", 'value'=> "tieup_type", 'children'=>array(
                    array('textStr'=> "ATR", "attr"=> array("name"=> "value", "value"=> "ATR")),
                    array('textStr'=> "QTR", "attr"=> array("name"=> "value", "value"=> "QTR")),
                    array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN00 Not assigned")),
                )
            )
        );

        $schemeId = $request->getParam("schemeId");
        $copy = $request->getParam("cpy");

        if (!empty($schemeId) ) {
            // TODO: Fix this hack of checking for scheme
            $scheme = \Akzo\Scheme\Service::getInstance()->getInitiatedScheme(
                $this->user,
                $schemeId
            );
            $data['userType'] = "initiator";
            if (empty($scheme)) {
                $scheme = \Akzo\Scheme\Service::getInstance()->getToBeReviewedScheme(
                    $this->user,
                    $schemeId
                );
                $data['userType'] = "reviewer";
            }
            if (empty($scheme)) {
                $scheme = \Akzo\Scheme\Service::getInstance()->getToBeApprovedScheme(
                    $this->user,
                    $schemeId
                );
                $data['userType'] = "approver";
            }
            $data["schemeData"] = $scheme->data;
            $data["state"] = $scheme->state;
            $data["schemeCode"] = $scheme->code;

            // Add transitions for this scheme
            $data['transitions'] = \Akzo\Scheme\Service::getInstance()->getSchemeTransitions($scheme);
            $this->logger->info("Transitions: " . print_r($data['transitions'], 1));

            $data['stateNamesMap'] = array(
                \Akzo\Scheme\State::CREATED => array(
                        "icon" => "asterisk",
                        "title" => "Scheme Created",
                ),
                \Akzo\Scheme\State::STAGED => array(
                        "icon" => "asterisk",
                        "title" => "Scheme Created",
                ),
                \Akzo\Scheme\State::UPDATE_REQUESTED => array(
                        "icon" => "refresh",
                        "title" => "Update Requested",
                ),
                \Akzo\Scheme\State::TO_BE_REVIEWED => array(
                        "icon" => "tag",
                        "title" => "To Be Reviewed",
                ),
                \Akzo\Scheme\State::TO_BE_APPROVED => array(
                        "icon" => "thumb-tack",
                        "title" => "To Be Approved",
                ),
                \Akzo\Scheme\State::APPROVED => array(
                        "icon" => "thumbs-up",
                        "title" => "Scheme Approved",
                )
            );

            $data['transitionNamesMap'] = array(
                \Akzo\Scheme\StateTransition::STAGE_SCHEME => array(
                    "name" => "Scheme Created",
                ),
                \Akzo\Scheme\StateTransition::UPDATE_STAGED_SCHEME => array(
                    "name" => "Scheme Updated",
                ),
                \Akzo\Scheme\StateTransition::INITIATE_CREATED_SCHEME => array(
                    "name" => "Scheme Initiated",
                ),
                \Akzo\Scheme\StateTransition::INITIATE_STAGED_SCHEME => array(
                    "name" => "Scheme Initiated",
                ),
                \Akzo\Scheme\StateTransition::REVIEW_SCHEME => array(
                    "name" => "Scheme Reviewed",
                ),
                \Akzo\Scheme\StateTransition::APPROVE_SCHEME => array(
                    "name" => "Scheme Approved",
                ),
                \Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE => array(
                    "name" => "Scheme Update Requested",
                ),
                \Akzo\Scheme\StateTransition::REQUEST_SCHEME_REVIEW => array(
                    "name" => "Scheme Review Requested",
                ),
                \Akzo\Scheme\StateTransition::UPDATE_SCHEME => array(
                    "name" => "Scheme Updated",
                ),
                \Akzo\Scheme\StateTransition::INITIATE_UPDATED_SCHEME => array(
                    "name" => "Updated Scheme Initiated",
                ),
            );
        }
        else{
            $data['userType'] = "creator";
        }

        if(!empty($copy)) {
            $data["schemeCode"] = null;
            $data['userType'] = "creator";
            $data["state"] = \Akzo\Scheme\State::CREATED;
        }
        $data["defaultStates"] = array(
            "staged" => \Akzo\Scheme\State::STAGED,
            "updateRequested" => \Akzo\Scheme\State::UPDATE_REQUESTED,
            "initiated" => \Akzo\Scheme\State::TO_BE_REVIEWED,
            "reviewed" => \Akzo\Scheme\State::TO_BE_APPROVED,
            "approved" => \Akzo\Scheme\State::APPROVED
        );
        $schemeService = \Akzo\Scheme\Service::getInstance();
        $data['schemesPendingApproval'] = $schemeService->getSchemesPendingApproval($this->user);
        $data['initiatedSchemes'] = $schemeService->listInitiatedSchemes($this->user);
        $data['toBeReviewedSchemes'] = $schemeService->listToBeReviewedSchemes($this->user);
        $data['toBeApprovedSchemes'] = $schemeService->listToBeApprovedSchemes($this->user);
        $data['draftSchemes'] = $schemeService->listDraftSchemes($this->user);

        // $this->logger->info("Scheme default: " . print_r($data['defaultStates'], 1));

        $this->__sendResponse('none', new \Native5\UI\TwigRenderer('template.tmpl'), $data);

    }//end _default()

    public function _products($request)
    {
        $productService = \Akzo\Product\Service::getInstance();
        $searchToken = $request->getParam('searchStr');
        $filter = $request->getParam('filter');

        if (isset($filter['products'])) {
            $products = $productService->getProducts($searchToken);
        }

        if (isset($filter['subbrands'])) {
            $subbrands = $productService->getProductSubBrands($searchToken);
        }

        if (isset($filter['groups'])) {
            $groups = $productService->getProductGroups($searchToken);
        }

        if (isset($filter['clusters'])) {
            $clusters = $productService->getProductCLusters($searchToken);
        }

        $productlist = array();
        if (!empty($products)) {
            foreach ($products as $idx => $res) {
                $productlist[] = array(
                    'name' => str_replace(',', '', $res->name)." (".$res->code.")",
                    'pid' => $res->pid
                );
                // $GLOBALS['logger']->info('PID: '.PHP_EOL.print_r($res->pid,1));
            }
        }

        $subbrandlist = array();
        if (!empty($subbrands)) {
            foreach ($subbrands as $idx => $res) {
                $subbrandlist[] = array(
                    'name' => str_replace(',', '', $res->name)." (".$res->code.")",
                    'pid' => $res->pid
                );
            }
        }

        $grouplist = array();
        if (!empty($groups)) {
            foreach ($groups as $idx => $res) {
                $grouplist[] = array(
                    'name' => str_replace(',', '', $res->name)." (".$res->code.")",
                    'pid' => $res->pid
                );
            }
        }

        $clusterlist = array();
        if (!empty($clusters)) {
            foreach ($clusters as $idx => $res) {
                $clusterlist[] = array(
                    'name' => str_replace(',', '', $res->name)." (".$res->code.")",
                    'pid' => $res->pid
                );
            }
        }

        // $GLOBALS['logger']->info('request is there'.PHP_EOL.print_r($productlist,1));

        $result = json_encode(
            array(
                array(
                    'name' => 'Default',
                    'children' => array(
                        array(
                            'name' => "All Products",
                            'pid' => "All"
                        )
                    ),
                    'disabled' => true
                ),
                array(
                    'name' => 'Clusters',
                    'children' => $clusterlist,
                    'disabled' => true
                ),
                array(
                    'name' => 'Sub Brands',
                    'children' => $subbrandlist,
                    'disabled' => true
                ),
                array(
                    'name' => 'Groups',
                    'children' => $grouplist,
                    'disabled' => true
                ),
                array(
                    'name' => 'Products',
                    'children' => $productlist,
                    'disabled' => true
                )
            )
        );

        // $GLOBALS['logger']->info('request is there'.PHP_EOL.print_r($result,1));
        // $jsondata = '[{'name':'cluster','children':[{'name':'Chillium','code':'ISOPOP'},{'name':'Netplode','code':'SARASONIC'},{'name':'Progenex','code':'ZEDALIS'},{'name':'Undertap','code':'MAGNEATO'},{'name':'Amtap','code':'EXPOSA'},{'name':'Kongene','code':'AMRIL'},{'name':'Uxmox','code':'LYRIA'},{'name':'Pheast','code':'COMVEX'},{'name':'Matrixity','code':'DATAGENE'},{'name':'Pearlesex','code':'NORSUL'}]},{'name':'group','children':[{'name':'Senmao','code':'VISALIA'},{'name':'Ecosys','code':'GLOBOIL'},{'name':'Zenolux','code':'LEXICONDO'},{'name':'Geekosis','code':'GOKO'},{'name':'Macronaut','code':'FANFARE'},{'name':'Eschoir','code':'KROG'},{'name':'Zyple','code':'COMFIRM'},{'name':'Multiflex','code':'SOFTMICRO'},{'name':'Comveyor','code':'ISOLOGIX'},{'name':'Voipa','code':'REPETWIRE'}]},{'name':'subbrand','children':[{'name':'Orbixtar','code':'FITCORE'},{'name':'Rotodyne','code':'LUNCHPAD'},{'name':'Callflex','code':'MANGLO'},{'name':'Microluxe','code':'SPEEDBOLT'},{'name':'Jetsilk','code':'VALREDA'}]},{'name':'product','children':[{'code':'CODACT','name':'Wendy Lopez','shortcode':'Thredz','packsize':6.107,'dpl':7720.43,'mrp':3443.05},{'code':'ZENTRY','name':'Harvey Lindsay','shortcode':'Cytrak','packsize':9.549,'dpl':9485.6,'mrp':3974.32},{'code':'CORMORAN','name':'Patrica Simmons','shortcode':'Locazone','packsize':6.885,'dpl':5143.81,'mrp':2124.88},{'code':'UNQ','name':'Dena Poole','shortcode':'Oulu','packsize':6.116,'dpl':4326.3,'mrp':2800.09},{'code':'QUIZKA','name':'Walker Owens','shortcode':'Caxt','packsize':5.716,'dpl':4293.69,'mrp':975},{'code':'ZBOO','name':'Burton Hatfield','shortcode':'Zinca','packsize':1.481,'dpl':1772.67,'mrp':3421.87}]}]';
        $json = json_decode($result, true);
        
        $this->_response = new HttpResponse('json');
        $this->_response->setBody($json);
    }

    public function _geography($request)
    {
        $searchToken = $request->getParam('searchStr');
        $filter = $request->getParam('filter');
        $geographyService = \Akzo\Geography\Service::getInstance();

        $includeRegions = false;

        // If the user is an ZM, search in its zone & its zones' depots
        if ($this->user->identity->type == \Akzo\User\IdentityType::ZM) {
            // Filter ZM's zone using the searchToken
            if (isset($filter['zones'])
                && preg_match('/'.$searchToken.'/i', $this->user->identity->zone->name)) {
                $zones = array($this->user->identity->zone);
            }

            // Filter depots under ZM's zone using the searchToken
            if (isset($filter['depots'])) {
                $depots = $geographyService->getDepotsInZone(
                    $this->user->identity->zone,
                    $searchToken
                );
            }

            if (isset($filter['dealers'])) {
                $dealers = $geographyService->getDealersInZone(
                    $this->user->identity->zone,
                    $searchToken
                );
            }

        // If the user is an RM, search in its region, its region's zones & its region's depots
        } else if ($this->identity->type == \Akzo\User\IdentityType::RM) {
            $includeRegions = true;
            // Filter RM's region using token
            if (isset($filter['regions'])
                && (preg_match('/'.$searchToken.'/i', $this->user->identity->region->name)
                    || preg_match('/'.$searchToken.'/i', $this->user->identity->region->code))) {
                $regions = array($this->user->identity->region);
            }

            // Filter zones under RM's region
            if (isset($filter['zones'])) {
                $zones = $geographyService->getZonesInRegion(
                    $this->user->identity->region,
                    $searchToken
                );
            }

            // Filter dealers under RM's region
            if (isset($filter['dealers'])) {
                $dealers = $geographyService->getDealersInRegion(
                    $this->user->identity->region,
                    $searchToken
                );
            }

            // Filter depots under ZM's zone
            if (isset($filter['depots'])) {
                $depots = $geographyService->getDepotsInRegion(
                    $this->user->identity->region,
                    $searchToken
                );
            }
        }

        $depotlist = array();
        if (!empty($depots)) {
            foreach ($depots as $idx => $res) {
                $depotlist[] = array(
                    'name' => str_replace(',', '', $res->name),
                    'gid' => $res->gid
                );
            }
        }

        $zonelist = array();
        if (!empty($zones)) {
            foreach ($zones as $idx => $res) {
                $zonelist[] = array(
                    'name' => str_replace(',', '', $res->name),
                    'gid' => $res->gid
                );
            }
        }

        $regionlist = array();
        if (!empty($regions) && $includeRegions) {
            foreach ($regions as $idx => $res) {
                $regionlist[] = array(
                    'name' => str_replace(',', '', $res->name),
                    'gid' => $res->gid
                );
            }
        }

        $dealerlist = array();
        if (!empty($dealers)) {
            foreach ($dealers as $idx => $res) {
                $dealerlist[] = array(
                    'name' => str_replace(',', '', $res->name),
                    'gid' => $res->gid
                );
            }
        }

        $result = array(
            array(
                'name' => 'Depots',
                'children' => $depotlist,
                'disabled' => true
            ),
            array(
                'name' => 'Zones',
                'children' => $zonelist,
                'disabled' => true
            ),
            array(
                'name' => 'Dealers',
                'children' => $dealerlist,
                'disabled' => true
            )
        );

        if ($includeRegions) {
            $result[] = 
                array(
                    'name' => 'Regions',
                    'children' => $regionlist,
                    'disabled' => true
                );
        }

        $this->__sendResponse('json', null, $result);
    }

    /**
     * _stage Create and save scheme as staged
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _stage($request)
    {
        list($data, $code) = $this->__retrieveSchemeData();

        $scheme = \Akzo\Scheme\Service::getInstance()->stageScheme(
            $this->user,
            $data
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _update Update a saved scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _update($request)
    {
        list($data, $code) = $this->__retrieveSchemeData();

        $scheme = \Akzo\Scheme\Service::getInstance()->updateScheme(
            $this->user,
            $data,
            $code
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _initiate Initiate a saved scheme or create an initiated scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _initiate($request)
    {
        list($data, $code) = $this->__retrieveSchemeData();

        $scheme = \Akzo\Scheme\Service::getInstance()->initiateScheme(
            $this->user,
            $data,
            $code
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _review Review an initiated scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _review($request)
    {
        $comment = $request->getParam('comment');
        $code = $request->getParam('schemeCode');
        $scheme = \Akzo\Scheme\Service::getInstance()->reviewScheme(
            $this->user,
            $code,
            $comment
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _approve Approve a reviewed scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _approve($request)
    {
        $comment = $request->getParam('comment');
        $code = $request->getParam('schemeCode');
        $scheme = \Akzo\Scheme\Service::getInstance()->approveScheme(
            $this->user,
            $code,
            $comment
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _requestUpdate Request update for an initiated or a reviewed scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _requestUpdate($request)
    {
        $comment = $request->getParam('comment');
        $code = $request->getParam('schemeCode');
        $scheme = \Akzo\Scheme\Service::getInstance()->requestSchemeUpdate(
            $this->user,
            $code,
            $comment
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _requestReview Request review for a reviewed scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _requestReview($request)
    {
        $comment = $request->getParam('comment');
        $code = $request->getParam('schemeCode');

        $scheme = \Akzo\Scheme\Service::getInstance()->requestSchemeReview(
            $this->user,
            $code,
            $comment
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    /**
     * _requestApprovedUpdate Request review for a reviewed scheme
     * 
     * @param mixed $request 
     * @access public
     * @return void
     */
    public function _requestApprovedUpdate($request)
    {
        $comment = $request->getParam('comment');
        $code = $request->getParam('schemeCode');

        $scheme = \Akzo\Scheme\Service::getInstance()->editApprovedScheme(
            $this->user,
            $code,
            $comment
        );

        $this->__sendResponse(
            'json',
            null,
            array('status' => true)
        );
    }

    // ******** Private Functions Follow ******** //

    private function __retrieveSchemeData() {
        // TODO: Fix getting data from php:://input, should be got from the request
        $data = file_get_contents('php://input');
        $dataArray = json_decode($data, true);

        // TODO: Remove local copy creation
        $saveDir = __DIR__.'/../logs/schemes';
        if (!file_exists($saveDir)) {
            mkdir($saveDir);
        }
        $saveNS = date("m-d-Y_H-i-s", time()).'-'.$this->user->username;

        file_put_contents($saveDir.'/'.$saveNS.'-scheme.json', json_encode($dataArray, JSON_PRETTY_PRINT));
        //file_put_contents($saveDir.'/'.$saveNS.'-schemeDataArray.log', print_r($dataArray, 1));

        // Retrieve the scheme Id
        $code = isset($dataArray['schemeHeaderTemplate']['id']) ? $dataArray['schemeHeaderTemplate']['id'] : null;

        return array(
            $data,
            $code
        );
    }
}
