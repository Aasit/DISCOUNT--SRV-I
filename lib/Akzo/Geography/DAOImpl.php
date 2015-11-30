<?php
namespace Akzo\Geography;
use \Respect\Validation\Validator as v;

class DAOImpl extends \Native5\Db\BaseDbDAO implements \Akzo\Geography\DAO
{
    // const QUERIES_FILE = 'queries.cfg.yml';

    public function __construct() {
        parent::__construct();
    }

    /**
     * loadDepots Load depots filtered by a region or a zone and/or a search token, sorted 
     *            by depot name. Token is searched among both of depot's name and code. If both region &
     *            zone are specified, zone is ignored.
     * 
     * @param \Akzo\Geography\Region $region Search depots under this region's zones.
     * @param \Akzo\Geography\Zone $zone Search depots under this zone.
     * @param string $token Filter depots whose name or code contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name or code of a depot,
     *                                else the token can be contained in the name or code
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Depot objects sorted by depot name
     */
    public function loadDepots(
        \Akzo\Geography\Region $region = null,
        \Akzo\Geography\Zone $zone = null,
        $token = null,
        $tokenExactMatch = false
    )
    {
        try {
            // Find base class to contruct query
            $static = false;
            if (!empty($region)) {
                $query = $region->depots();
            } else if (!empty($zone)) {
                $query = $zone->depots();
            } else {
                $query = '\Akzo\Geography\Depot';
                $static = true;
            }

            // Check if query needs filtering by token
            if (!empty($token)) {
                if (!$tokenExactMatch) {
                    $GLOBALS['searchToken'] = '%'.$token.'%';
                } else {
                    $GLOBALS['searchToken'] = $token;
                }

                // Hardcode table column names or they can be ambiguous in joins
                if ($static) {
                    $query = $query::where(function($q)
                        {
                            $q->where(\Akzo\Geography\Depot::TABLE_NAME.'.code', 'like', $GLOBALS['searchToken'])
                                ->orWhere(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'like', $GLOBALS['searchToken']);
                        });
                } else {
                    $query = $query->where(function($q)
                        {
                            $q->where(\Akzo\Geography\Depot::TABLE_NAME.'.code', 'like', $GLOBALS['searchToken'])
                                ->orWhere(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'like', $GLOBALS['searchToken']);
                        });
                }
                $query = $query->orderBy(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'ASC');
            } else {
                // Hardcode table column names or they can be ambiguous in joins
                if ($static) {
                    $query = $query::orderBy(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'ASC');
                } else {
                    $query = $query->orderBy(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'ASC');
                }
            }
            
            $depots = $query
                ->get()
                ->all();

            if (isset($GLOBALS['searchToken'])) {
                unset($GLOBALS['searchToken']);
            }
            return $depots;
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    /**
     * loadZones Load zones filtered by a region and/or a search token, sorted by zone name.
     *           Token is searched in the zone's name.
     * 
     * @param \Akzo\Geography\Region $region Search zones under this region.
     * @param string $token Filter zone whose name contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name of a zone,
     *                                else the token can be contained in the name
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Zone objects sorted by zone name
     */
    public function loadZones(
        \Akzo\Geography\Region $region = null,
        $token = null,
        $tokenExactMatch = false
    )
    {
        try {
            // Find base class to contruct query
            $static = false;
            if (!empty($region)) {
                $query = $region->zones();
            } else {
                $query = '\Akzo\Geography\Zone';
                $static = true;
            }

            // Check if query needs filtering by token
            if (!empty($token)) {
                if (!$tokenExactMatch) {
                    $token = '%'.$token.'%';
                }

                // Hardcode table column names or they can be ambiguous in joins
                if ($static) {
                    $query = $query::where(\Akzo\Geography\Zone::TABLE_NAME.'.name', 'like', $token);
                } else {
                    $query = $query->where(\Akzo\Geography\Zone::TABLE_NAME.'.name', 'like', $token);
                }
                $query = $query->orderBy(\Akzo\Geography\Zone::TABLE_NAME.'.name', 'ASC');
            } else {
                // Hardcode table column names or they can be ambiguous in joins
                if ($static) {
                    $query = $query::orderBy(\Akzo\Geography\Zone::TABLE_NAME.'.name', 'ASC');
                } else {
                    $query = $query->orderBy(\Akzo\Geography\Zone::TABLE_NAME.'.name', 'ASC');
                }
            }

            return $query
                ->get()
                ->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    /**
     * loadRegions Load regions, alternatively filtered by a search token, sorted by region name.
     *             Token is searched both among the region's name and code.
     * 
     * @param string $token Filter region whose name or code contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name or code of a region,
     *                                else the token can be contained in the name or code
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Region objects sorted by region name
     */
    public function loadRegions(
        $token = null,
        $tokenExactMatch = false
    )
    {
        try {
            // Base class to contruct query
            $query = '\Akzo\Geography\Zone';

            // Check if query needs filtering by token
            if (!empty($token)) {
                if (!$tokenExactMatch) {
                    $token = '%'.$token.'%';
                }

                $query = $query::where('name', 'like', $token)
                    ->orWhere('code', 'like', $token)
                    ->orderBy('name', 'ASC');
            } else {
                $query = $query::orderBy('name', 'ASC');
            }

            return $query
                ->get()
                ->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }



// Older functions to be revamped

    public function getDepotsInZone(\Akzo\Geography\Zone $zone, $token = null)
    {
        try {
            if (empty($token)) {
                return $zone
                    ->depots()
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->all();
            } else {
                $token = '%'.$token.'%';
                return $zone
                    ->depots()
                        ->where('code', 'like', $token)
                        ->orWhere('name', 'like', $token)
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->all();
            }
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDepotsInRegion(\Akzo\Geography\Region $region, $token = null)
    {
        try {
            if (empty($token)) {
                return $region
                    ->depots()
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->all();
            } else {
                $token = '%'.$token.'%';
                return $region
                    ->depots()
                        ->where(\Akzo\Geography\Depot::TABLE_NAME.'.code', 'like', $token)  // Need to hardcode table name
                        ->orWhere(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'like', $token)
                        ->orderBy(\Akzo\Geography\Depot::TABLE_NAME.'.name', 'ASC')
                        ->get()
                        ->all();
            }
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getZonesInRegion(\Akzo\Geography\Region $region, $token = null)
    {
        try {
            if (empty($token)) {
                return $region
                    ->zones()
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->all();
            } else {
                $token = '%'.$token.'%';
                return $region
                    ->zones()
                        ->where('name', 'like', $token)
                        ->orderBy('name', 'ASC')
                        ->get()
                        ->all();
            }
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getRegionForRM(\Akzo\User\RM $rm, $token = null)
    {
        try {
            if (empty($token)) {
                return $rm->region;
            } else {
                $token = '%'.$token.'%';
                return $rm
                    ->region()
                        ->where('name', 'like', $token)
                        ->orWhere('code', 'like', $token)
                        ->get()
                        ->first(); 
            }
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getZoneForZM(\Akzo\User\ZM $zm, $token = null)
    {
        try {
            if (empty($token)) {
                return $zm->zone;
            } else {
                $token = '%'.$token.'%';
                return $zm
                    ->zone()
                        ->where('name', 'like', $token)
                        ->get()
                        ->first(); 
            }
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDealersInDepot(\Akzo\Geography\Depot $depot)
    {
        try {
            return $depot->dealers()
                ->orderBy('name', 'ASC')
                ->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDealerIDsUnderZM(\Akzo\User\ZM $zm)
    {
        try {
            return $zm->zone->dealers()
                ->orderBy('name', 'ASC')
                ->select('ak_sales_dealers.*')
                ->lists('id');
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDealersInZone(\Akzo\Geography\Zone $zone, $token)
    {
        try {
            $token = '%'.$token.'%';
            return $zone->dealers()
                ->orderBy('name', 'ASC')
                ->where('ak_sales_dealers.code','like',$token)
                ->orWhere('ak_sales_dealers.name','like',$token)
                ->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }


    public function getDealersInRegion(\Akzo\Geography\Region $region,
        $token = null)
    {
        try {
            $token = '%'.$token.'%';
            $depots = $region->depots()->get()->all();

            $dealers = array();
            foreach ($depots as $idx=>$depot) {
                $tempDealer = $depot->dealers()
                    ->orderBy('name', 'ASC')
                    ->where('ak_sales_dealers.code','like',$token)
                    ->orWhere('ak_sales_dealers.name','like',$token)
                    ->get()->all();
                $dealers = array_merge(
                    $dealers,
                    $tempDealer
                );
                // $GLOBALS['logger']->info("Dealers: ".count($dealers)." |||||||||||||||||||||".PHP_EOL);
                
            }
            return $dealers;
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getAllRegions()
    {
        try {
            return \Akzo\Geography\Region
                ::orderBy('code', 'ASC')
                ->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function searchRegions($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Geography\Region::with(
                array(
                    'zones'
                )
            )->where('code','like',$token)->orWhere('name','like',$token)->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function getAllZones()
    {
        try {
            return \Akzo\Geography\Zone
                ::orderBy('region_id', 'ASC')
                ->orderBy('name', 'ASC')
                ->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function searchZones($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Geography\Zone::with(
                array(
                    'depots', 
                    'region'
                )
            )->where('name','like',$token)->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function getAllDepots()
    {
        try {
            return \Akzo\Geography\Depot
                ::orderBy('zone_id', 'ASC')
                ->orderBy('name', 'ASC')
                ->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }  

    public function searchDepots($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Geography\Depot::with(
                array(
                    'zone', 
                    'dealers'
                )
            )->where('code','like',$token)->orWhere('name','like',$token)->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function getAllDealers()
    {
        try {
            return \Akzo\Dealer
                ::orderBy('depot_id', 'ASC')
                ->orderBy('name', 'ASC')
                ->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDealerByName($name)
    {
        $this->_validate($name, "name");
        try {
            return \Akzo\Dealer
                ::where('name', 'like', $name)
                ->first();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDealerByCode($code)
    {
        $this->_validate($code, "code");
        try {
            return \Akzo\Dealer
                ::where('code', 'like', $code)
                ->first();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function loadDealerGroupedByCreditCode($code)
    {
        $this->_validate($code, "code");
        try {
            return \Akzo\Dealer
                ::where('credit_code', 'like', $code)
                ->selectRaw("GROUP_CONCAT(`ak_sales_dealers`.`id`) `cids`, GROUP_CONCAT(`ak_sales_dealers`.`code`) `ccodes`")
                ->groupBy('credit_code')
                ->get()
                ->first();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getZoneByName($name)
    {
        $this->_validate($name, "name");
        try {
            return \Akzo\Geography\Zone
                ::where('name', 'like', $name)
                ->first();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getRegionByName($name)
    {
        $this->_validate($name, "name");
        try {
            return \Akzo\Geography\Region
                ::where('name', 'like', $name)
                ->first();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDepotByCode($code)
    {
        $this->_validate($code, "code");
        try {
            return \Akzo\Geography\Depot
                ::where('code', 'like', $code)
                ->first();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }



    private function _validate($param, $type)
    {
        $libConfig = $GLOBALS['app']->getConfiguration()->getRawConfiguration('library');
        $minNameVal = $libConfig["product"]["minNameLength"];
        $maxNameVal = $libConfig["product"]["maxNameLength"];
        $minCodeVal = $libConfig["product"]["minCodeLength"];
        $maxCodeVal = $libConfig["product"]["maxCodeLength"];

        $validateName = v::alnum('-_')->length($minNameVal, $maxNameVal);
        $validateCode = v::alnum('-_')->noWhitespace()->length($minCodeVal, $maxCodeVal);
        $validateToken = v::alnum('-_');


        if($type == "name") {
            $isValid = $validateName->validate($param);
            if (!$isValid) {
                throw new \InvalidArgumentException(
                    \Akzo\Product\ErrorMessages::INVALID_PRODUCT_NAME, 
                    \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
                );
            }
        }

        else if ($type == "code") {
            $isValid = $validateCode->validate($param);
            if (!$isValid) {
                throw new \InvalidArgumentException(
                    \Akzo\Product\ErrorMessages::INVALID_PRODUCT_CODE, 
                    \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
                );
            }
        }
        
        else if($type == "token") {
            $isValid = $validateToken->validate($param);
            if (!$isValid) {
                throw new \InvalidArgumentException(
                    \Akzo\Product\ErrorMessages::INVALID_TOKEN, 
                    \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
                );
            }
        }

        else {
            throw new \InvalidArgumentException(
                'Invalid Validation Type',
                \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
            );
        }

    }

}
