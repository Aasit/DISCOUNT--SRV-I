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
class demoController extends DefaultController
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
        $renderer =  new TwigRenderer('demo.tmpl');
        $this->_response = new HttpResponse('none', $renderer);
        $this->_response->setBody(array());

    }//end _default()

    public function _select($request) 
    {   
        $productService = \Akzo\Product\Service::getInstance();
        $searchToken = $request->getParam("searchStr");
        $filter = $request->getParam("filter");
        $products; $groups; $subbrands;

        if (isset($filter['products'])) {
            $products = $productService->getProducts($searchToken);
        }

        if (isset($filter['subbrands'])) {
            $subbrands = $productService->getProductSubBrands($searchToken);
        }

        if (isset($filter['groups'])) {
            $groups = $productService->getProductGroups($searchToken);
        }

        $productlist = array();
        foreach ($products as $idx=>$res) {
            $productlist[] = array(
                'name' => $res->name,
                'code' => $res->name
            );
        }

        $subbrandlist = array();
        foreach ($subbrands as $idx=>$res) {
            $subbrandlist[] = array(
                'name' => $res->name,
                'code' => $res->name
            );
        }

        $grouplist = array();
        foreach ($groups as $idx=>$res) {
            $grouplist[] = array(
                'name' => $res->name,
                'code' => $res->name
            );
        }

        // $GLOBALS['logger']->info("request is there".PHP_EOL.print_r($productlist,1));

        $result = json_encode(
            array(
                array(
                    "name" => "Products",
                    "children" => $productlist,
                    "disabled" => true
                ),
                array(
                    "name" => "Sub Brands",
                    "children" => $subbrandlist,
                    "disabled" => true
                ),
                array(
                    "name" => "Groups",
                    "children" => $grouplist,
                    "disabled" => true
                )
            )
        );

        // $GLOBALS['logger']->info("request is there".PHP_EOL.print_r($result,1));
        // $jsondata = '[{"name":"cluster","children":[{"name":"Chillium","code":"ISOPOP"},{"name":"Netplode","code":"SARASONIC"},{"name":"Progenex","code":"ZEDALIS"},{"name":"Undertap","code":"MAGNEATO"},{"name":"Amtap","code":"EXPOSA"},{"name":"Kongene","code":"AMRIL"},{"name":"Uxmox","code":"LYRIA"},{"name":"Pheast","code":"COMVEX"},{"name":"Matrixity","code":"DATAGENE"},{"name":"Pearlesex","code":"NORSUL"}]},{"name":"group","children":[{"name":"Senmao","code":"VISALIA"},{"name":"Ecosys","code":"GLOBOIL"},{"name":"Zenolux","code":"LEXICONDO"},{"name":"Geekosis","code":"GOKO"},{"name":"Macronaut","code":"FANFARE"},{"name":"Eschoir","code":"KROG"},{"name":"Zyple","code":"COMFIRM"},{"name":"Multiflex","code":"SOFTMICRO"},{"name":"Comveyor","code":"ISOLOGIX"},{"name":"Voipa","code":"REPETWIRE"}]},{"name":"subbrand","children":[{"name":"Orbixtar","code":"FITCORE"},{"name":"Rotodyne","code":"LUNCHPAD"},{"name":"Callflex","code":"MANGLO"},{"name":"Microluxe","code":"SPEEDBOLT"},{"name":"Jetsilk","code":"VALREDA"}]},{"name":"product","children":[{"code":"CODACT","name":"Wendy Lopez","shortcode":"Thredz","packsize":6.107,"dpl":7720.43,"mrp":3443.05},{"code":"ZENTRY","name":"Harvey Lindsay","shortcode":"Cytrak","packsize":9.549,"dpl":9485.6,"mrp":3974.32},{"code":"CORMORAN","name":"Patrica Simmons","shortcode":"Locazone","packsize":6.885,"dpl":5143.81,"mrp":2124.88},{"code":"UNQ","name":"Dena Poole","shortcode":"Oulu","packsize":6.116,"dpl":4326.3,"mrp":2800.09},{"code":"QUIZKA","name":"Walker Owens","shortcode":"Caxt","packsize":5.716,"dpl":4293.69,"mrp":975},{"code":"ZBOO","name":"Burton Hatfield","shortcode":"Zinca","packsize":1.481,"dpl":1772.67,"mrp":3421.87}]}]';
        $json = json_decode($result, true);
        
        $this->_response = new HttpResponse('json');
        $this->_response->setBody($json);
    }

    public function _data($request) 
    {   
        $GLOBALS['logger']->info("request is here");
        $region = $request->getParam("region");
        $jsondata = 
            '{"0":{
                "name": "Asia",
                "level" : 0,
                "event": "clickEvent",
                "style": "abc",
                "children": [
                {
                    "name": "India",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": [
                    {
                        "name": "karnatka",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                    },
                    {
                        "name": "kerla",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                    }
                    ]
                },
                {
                    "name": "Pakistan",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": [
                    {
                        "name": "Karachi",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                    },
                    {
                        "name": "Rawalpindi",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                    },
                    {
                        "name": "Pishawar",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": [
                        {
                            "name": "soubiSarhad",
                            "level" : 2,
                            "event": "ClickEvent2",
                            "style": "xyz",
                            "children": null 
                        }
                        ]
                    }
                    ]
                },
                {
                    "name": "Russia",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                },
                {
                    "name": "Bangaldesh",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                },
                {
                    "name": "China",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": [
                    {
                        "name": "Bejing",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                     },
                    {
                        "name": "chun ki",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                    }
                    ]
                }
                ]
            },
            "1":{
                "name": "Africa",
                "level" : 0,
                "event": "clickEvent",
                "style": "abc",
                "children": [
                {
                    "name": "Libya",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                },
                {
                    "name": "Egypt",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                },
                {
                    "name": "Rawand",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                },
                {
                    "name": "zimbawe",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                }
                ]
            },
            "2":{
                "name": "Europe",
                "level" : 0,
                "event": "clickEvent",
                "style": "abc",
                "children": [
                {
                    "name": "wales",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": [
                    {
                        "name": "Distim",
                        "level" : 2,
                        "event": "ClickEvent2",
                        "style": "xyz",
                        "children": null
                    }
                    ]
                },
                {
                    "name": "England",
                    "level" : 1,
                    "event": "ClickEvent2",
                    "style": "xyz",
                    "children": null
                }
                ]
            }}';
        
        $json = json_decode($jsondata, true);
        $GLOBALS['logger']->info("region".PHP_EOL.$region);
        if($region == "Asia") {
            $data = $json[0]["children"];
        }

        else if($region == "Africa") {
            $data = $json[1]["children"];    
        }

        else if ($region == "Europe") {
            $data = $json[2]["children"];    
        }
        sleep(1);
        // $GLOBALS['logger']->info("request is there".PHP_EOL.print_r($json,1));
        $this->_response = new HttpResponse('json');
        $this->_response->setBody($data);
    }


}//end class

