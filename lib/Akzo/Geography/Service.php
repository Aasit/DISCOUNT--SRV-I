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

namespace Akzo\Geography;
use \Respect\Validation\Validator as v;

/**
 * Service Akzo Product
 *
 * @category Class
 * @package  Akzo\Product
 * @author   Anurag Dadheech <anurag.dadheech@native5.com>
 * @license  See attached LICENSE for details
 * @link     http://www.docs.native5.com 
 *
 */
class Service
{
    private $_dao;
    private $_logger;

    /**
     * 
     * @var Singleton
     */
    private static $_instance;

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
        $this->_dao = new \Akzo\Geography\DAOImpl();
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

    public function getDealerByCode($code) {
        return $this->_dao->getDealerByCode($code);
    }

    public function getDealerGroupedByCreditCode($code) {
        return $this->_dao->loadDealerGroupedByCreditCode($code);
    }

    /**
     * getDepotsInZone Get depots under a zone and/or a search token, sorted by depot name. 
     *                 Token is searched among both of depot's name and code.
     * 
     * @param \Akzo\Geography\Zone $zone Search depots under this zone.
     * @param string $token Filter depots whose name or code contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name or code of a depot,
     *                                else the token can be contained in the name or code
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Depot objects sorted by depot name
     */
    public function getDepotsInZone(
        \Akzo\Geography\Zone $zone,
        $token = null,
        $tokenExactMatch = false
    )
    {
        return $this->_dao->loadDepots(
            null,
            $zone,
            $token,
            $tokenExactMatch
        );
    }

    /**
     * getDalersInZone Get dealers under a zone and/or a search token, sorted by dealer name. 
     *                 Token is searched among both of dealer's name and code.
     * 
     * @param \Akzo\Geography\Zone $zone Search dealers under this zone.
     * @param string $token Filter dealers whose name or code contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name or code of a dealer,
     *                                else the token can be contained in the name or code
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Dealer objects sorted by dealer name
     */
    public function getDealersInZone(
        \Akzo\Geography\Zone $zone,
        $token = null,
        $tokenExactMatch = false
    )
    {
        return $this->_dao->getDealersInZone(
            $zone,
            $token
        );
    }

    /**
     * getDepotsInRegion Get depots under a region and/or a search token, sorted by depot name. 
     *                   Token is searched among both of depot's name and code.
     * 
     * @param \Akzo\Geography\Region $region Search depots under this region.
     * @param string $token Filter depots whose name or code contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name or code of a depot,
     *                                else the token can be contained in the name or code
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Depot objects sorted by depot name
     */
    public function getDepotsInRegion(
        \Akzo\Geography\Region $region,
        $token = null,
        $tokenExactMatch = false
    )
    {
        return $this->_dao->loadDepots(
            $region,
            null,
            $token,
            $tokenExactMatch
        );
    }

    /**
     * getDealersInRegion Get Dealers under a region and/or a search token, sorted by depot name. 
     *                   Token is searched among both of depot's name and code.
     * 
     * @param \Akzo\Geography\Region $region Search Dealers under this region.
     * @param string $token Filter Dealers whose name or code contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name or code of a depot,
     *                                else the token can be contained in the name or code
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Depot objects sorted by depot name
     */
    public function getDealersInRegion(
        \Akzo\Geography\Region $region,
        $token = null
    )
    {
        return $this->_dao->getDealersInRegion(
            $region,
            $token,
            $tokenExactMatch
        );
    }

    /**
     * getZonesInRegion Get zone under a region and/or a search token, sorted by zone name. 
     *                  Token is searched in zone's name.
     * 
     * @param \Akzo\Geography\Region $region Search zone under this region.
     * @param string $token Filter zones whose name contains or is an exact match of the search token.
     * @param string $tokenExactMatch If true, the token should exactly match the name of a zone,
     *                                else the token can be contained in the name
     * @access public
     * @return Eloquent Collection of matching \Akzo\Geography\Zone objects sorted by zone name
     */
    public function getZonesInRegion(
        \Akzo\Geography\Region $region,
        $token = null,
        $tokenExactMatch = false
    )
    {
        return $this->_dao->loadZones(
            $region,
            $token,
            $tokenExactMatch
        );
    }

    /**
     * getAllDealers Get all the dealers in an array
     * @access public
     * @return array Arry of dealers
     */
    public function getAllDealers()
    {
        return $this->_dao->getAllDealers();
    }

    // FIXME: Bad coding!!
    public function getDealersByGid($gid, $attributes = array(), $segments = array(), $groupDealersByCreditCode = false, $offset = 0, $count = null) {
        // The first character of the gid is type
        $gidType = substr($gid, 0, 1);
        // The rest is the id
        $id = substr($gid, 1);
        
        // Sort the attributes
        if (!empty($attributes)) {
            $attributes = $this->_sortAttributes($attributes);
        }

        if (strcmp($gidType, 'C') === 0) {  // Dealer (Customer)
            return array(\Akzo\Dealer::find($id));
            //$query = \Akzo\Dealer::where("id", "=",(int) $id);
        } else if (strcmp($gidType, 'D') === 0) {  // Depot
            $query = \Akzo\Geography\Depot::find($id)->dealers();
        } else if (strcmp($gidType, 'Z') === 0) {  // Zones
            $query = \Akzo\Geography\Zone::find($id)->dealers(); //->all();
        }

        // Add the attributes to the query
        if (!empty($attributes)) {
            foreach ($attributes as $attrKey=>$attr) {
                if (isset($attr['included']) && !empty($attr['included'])) {
                    $query = $query->whereIn($attrKey, $attr['included']);
                }
                if (isset($attr['excluded']) && !empty($attr['excluded'])) {
                    $query = $query->whereNotIn($attrKey, $attr['excluded']);
                }
            }
        }

        if (!empty($segments)) {
            // $this->logger->info("Has segments");
            $query = $query->whereIn('segment', $segments);
        }

        if (!empty($count)) {
            $query = $query
                ->take($count)
                ->skip($offset);
        }

        if ($groupDealersByCreditCode) {
            // Group concat ids and code
            $query = $query
                ->selectRaw("GROUP_CONCAT(`ak_sales_dealers`.`id`) `cids`, GROUP_CONCAT(`ak_sales_dealers`.`code`) `ccodes`")
                ->groupBy('credit_code');
        }

        return $query
            ->orderBy('id')
            ->get()
            ->all();
    }

    public function _sortAttributes($attributes) {
        $attrs = array();
        foreach ($attributes as $idx=>$attr) {
            if (!isset($attrs[$attr->type])) {
                $attrs[$attr->type] = array();
                $attrs[$attr->type]['included'] = array();
                $attrs[$attr->type]['excluded'] = array();
            }
            if (isset($attr->excluded) && ($attr->excluded === true)) {
                $attrs[$attr->type]['excluded'][] = $attr->attr;
            } else {
                $attrs[$attr->type]['included'][] = $attr->attr;
            }
        }

        return $attrs;
    }

    //public function getZonesInRegion($name)
    //{
        //try {
            //$region = $this->_dao->getRegionByName($name);
            //return $this->_dao->getZonesInRegion($region);
        //} catch (\PDOException $e) {
            //$GLOBALS['logger']->info("Error: ".$e->getMessage());
            //throw new \InvalidArgumentException(
                //\Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                //\Native5\Core\Http\StatusCodes::BAD_REQUEST
            //);
        //}
        
    //}

    //public function getDepotsInZone($name)
    //{
        //try {
            //$zone = $this->_dao->getZoneByName($name);
            //return $this->_dao->getDepotsInZone($zone);
        //} catch (\PDOException $e) {
            //$GLOBALS['logger']->info("Error: ".$e->getMessage());
            //throw new \InvalidArgumentException(
                //\Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                //\Native5\Core\Http\StatusCodes::BAD_REQUEST
            //);
        //}
        
    //}

    public function getDealersInDepot($code)
    {
        try {
            $depot = $this->_dao->getdepotByCode($code);
            return $this->_dao->getDealersInDepot($depot);
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
            return $this->_dao->getDealerIDsUnderZM($zm);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getDepots($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllDepots();
            else
                return $this->_dao->searchDepots($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getZones($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllZones();
            else
                return $this->_dao->searchZones($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getRegions($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllRegions();
            else
                return $this->_dao->searchRegions($token);
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
