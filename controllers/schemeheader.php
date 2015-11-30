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
class schemeheaderController extends \Akzo\Control\ProtectedController
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
        $data['segmentTypes'] = array(
                array('textStr'=> "70 Trade", "attr"=> array("name"=> "value", "value"=> "seg1")),
                array('textStr'=> "76 Direct", "attr"=> array("name"=> "value", "value"=> "seg2")),
                array('textStr'=> "76 RS", "attr"=> array("name"=> "value", "value"=> "seg3")),
                array('textStr'=> "76 Sub Dealer", "attr"=> array("name"=> "value", "value"=> "seg4")),
                array('textStr'=> "77 MR Bharat", "attr"=> array("name"=> "value", "value"=> "seg5")),
                array('textStr'=> "77 MR Trade", "attr"=> array("name"=> "value", "value"=> "seg6")),
                array('textStr'=> "74 Professional", "attr"=> array("name"=> "value", "value"=> "seg7"))
            );

        $data['dealerTypes'] = array(
                array('name'=>"Segmentation", 'children'=>array(
                        array('textStr'=> "CSSB1", "attr"=> array("name"=> "value", "value"=> "CSSB1")),
                        array('textStr'=> "CSSB2", "attr"=> array("name"=> "value", "value"=> "CSSB2")),
                        array('textStr'=> "Distributor", "attr"=> array("name"=> "value", "value"=> "Distributor")),
                        array('textStr'=> "Dulux Point", "attr"=> array("name"=> "value", "value"=> "Dulux")),
                        array('textStr'=> "Gold", "attr"=> array("name"=> "value", "value"=> "Gold")),
                        array('textStr'=> "Others", "attr"=> array("name"=> "value", "value"=> "Others")),
                        array('textStr'=> "Platinum", "attr"=> array("name"=> "value", "value"=> "Platinum")),
                        array('textStr'=> "POS1", "attr"=> array("name"=> "value", "value"=> "POS1")),
                        array('textStr'=> "POS2", "attr"=> array("name"=> "value", "value"=> "POS2")),
                        array('textStr'=> "POS3", "attr"=> array("name"=> "value", "value"=> "POS3")),
                        array('textStr'=> "Professional NKA", "attr"=> array("name"=> "value", "value"=> "Professional")),
                        array('textStr'=> "Silver", "attr"=> array("name"=> "value", "value"=> "Silver")),
                        array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN004"))
                    )                        
                ),
                array('name'=>"CSS Type", 'children'=>array(
                        array('textStr'=> "CSS - Automatic", "attr"=> array("name"=> "value", "value"=> "Automatic")),
                        array('textStr'=> "CSS - Manual", "attr"=> array("name"=> "value", "value"=> "Manual")),
                        array('textStr'=> "DCC", "attr"=> array("name"=> "value", "value"=> "DCC")),
                        array('textStr'=> "Non CSS", "attr"=> array("name"=> "value", "value"=> "Non")),
                        array('textStr'=> "Non-DCC", "attr"=> array("name"=> "value", "value"=> "Non-DCC")),
                        array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN00"))
                    )                        
                ),
                array('name'=>"Dealer Type", 'children'=>array(
                        array('textStr'=> "ANI Exclusive", "attr"=> array("name"=> "value", "value"=> "ANI")),
                        array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN0056")),
                    )                        
                ),
                array('name'=>"Town Tier", 'children'=>array(
                        array('textStr'=> "Developer", "attr"=> array("name"=> "value", "value"=> "Developer")),
                        array('textStr'=> "Non-Developer", "attr"=> array("name"=> "value", "value"=> "Non-Developer")),
                        array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN0057")),
                    )                        
                ),
                array('name'=>"Tie Up Type", 'children'=>array(
                        array('textStr'=> "ATR", "attr"=> array("name"=> "value", "value"=> "ATR")),
                        array('textStr'=> "QTR", "attr"=> array("name"=> "value", "value"=> "QTR")),
                        array('textStr'=> "IN00 Not assigned", "attr"=> array("name"=> "value", "value"=> "IN0058")),
                    )                        
                )
            );
        $this->_sendResponse(new \Native5\UI\TwigRenderer('schemeHeader.tmpl'), $data, 'none');

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
                    'name' => $res->name." (".$res->code.")",
                    'pid' => $res->pid
                );
                // $GLOBALS['logger']->info('PID: '.PHP_EOL.print_r($res->pid,1));
            }
        }

        $subbrandlist = array();
        if (!empty($subbrands)) {
            foreach ($subbrands as $idx => $res) {
                $subbrandlist[] = array(
                    'name' => $res->name." (".$res->code.")",
                    'pid' => $res->pid
                );
            }
        }

        $grouplist = array();
        if (!empty($groups)) {
            foreach ($groups as $idx => $res) {
                $grouplist[] = array(
                    'name' => $res->name." (".$res->code.")",
                    'pid' => $res->pid
                );
            }
        }

        $clusterlist = array();
        if (!empty($clusters)) {
            foreach ($clusters as $idx => $res) {
                $clusterlist[] = array(
                    'name' => $res->name." (".$res->code.")",
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
        $geographyService = \Akzo\Geography\Service::getInstance();
        $searchToken = $request->getParam('searchStr');
        $filter = $request->getParam('filter');

        if (isset($filter['depots'])) {
            $depots = $geographyService->getDepots($searchToken);
        }

        if (isset($filter['zones'])) {
            $zones = $geographyService->getZones($searchToken);
        }

        if (isset($filter['regions'])) {
            $regions = $geographyService->getRegions($searchToken);
        }

        $depotlist = array();
        if (!empty($depots)) {
            foreach ($depots as $idx => $res) {
                $depotlist[] = array(
                    'name' => $res->name,
                    'gid' => $res->gid
                );
            }
        }

        $zonelist = array();
        if (!empty($zones)) {
            foreach ($zones as $idx => $res) {
                $zonelist[] = array(
                    'name' => $res->name,
                    'gid' => $res->gid
                );
            }
        }

        $regionlist = array();
        if (!empty($regions)) {
            foreach ($regions as $idx => $res) {
                $regionlist[] = array(
                    'name' => $res->name,
                    'gid' => $res->gid
                );
            }
        }

        // $GLOBALS['logger']->info('request is there'.PHP_EOL.print_r($productlist,1));

        $result = json_encode(
            array(
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
                    'name' => 'Regions',
                    'children' => $regionlist,
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

    public function _save($request)
    {
        $rawSchemeData = file_get_contents('php://input');
        $schemeData = json_decode($rawSchemeData);

        $saveDir = __DIR__.'/../logs/schemes';
        if (!file_exists($saveDir)) {
            mkdir ($saveDir);
        }
        $saveNS = date("m-d-Y_H-i-s", time()).'-'.$this->user->username;

        file_put_contents($saveDir.'/'.$saveNS.'-rawSchemeData.log', $rawSchemeData);
        file_put_contents($saveDir.'/'.$saveNS.'-schemeDataArray.log', print_r($schemeData, true));

        // Call create scheme API
        $schemeCreationStatus = \Akzo\Scheme\Service::getInstance()->createScheme(
            $this->user,
            $rawSchemeData
        );

        $this->_sendResponse(
            null,
            array('status' => $schemeCreationStatus),
            'json'
        );

        //$GLOBALS['logger']->info("Request is: ".print_r($request, 1));
        //// $schemeData = $request->getParam('schemedata');
        //$rawSchemeData = file_get_contents('php://input');
        //$schemeData = json_decode($rawSchemeData);
        //$GLOBALS['logger']->info('schemedata: '.PHP_EOL.print_r($rawSchemeData, 1));

        //$path = __DIR__.'/../tests/unit/Akzo/Test/Scheme/schemeData.json';
        //file_put_contents($path, json_encode($schemeData));
    }

    private function _sendResponse($renderer = null, $renderData = array(), $encoding = 'json')
    {
        $this->_response = new \Native5\Route\HttpResponse($encoding, $renderer);
        $this->_response->addHeader('Cache-Control: no-cache, must-revalidate');
        $this->_response->setBody($renderData);
    }
}
