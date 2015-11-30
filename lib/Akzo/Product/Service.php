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

namespace Akzo\Product;
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
        $this->_dao = new \Akzo\Product\DAOImpl();
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

    /** @param $products \Akzo\Scheme\Data\Common\Product[] */
    public function transformProductsToIds(
        $products,
        $projectSku,
        $packTypes = array(
            \Akzo\Scheme\Data\Common\Product\PackType::RETAIL,
            \Akzo\Scheme\Data\Common\Product\PackType::BULK
        )
    )
    {
        // Initialize the include / exclude Product Ids
        $includedProductIds = $excludedProductIds = array();

        // Iterate through the products and create the included / excluded array
        foreach ($products as $idx=>$product) {
            if (isset($product->excluded) && ($product->excluded == true)) {
                $excludedProductIds
                    = array_merge(
                        $excludedProductIds,
                        \Akzo\Product\Service::getInstance()
                            ->getProductIdsByPid($product->pid, $packTypes, $projectSku)
                    );
            } else {
                $includedProductIds
                    = array_merge(
                        $includedProductIds,
                        \Akzo\Product\Service::getInstance()
                            ->getProductIdsByPid($product->pid, $packTypes, $projectSku)
                    );
            }
        }

        // Return a differential of the included and excluded products
        return array_diff(
            $includedProductIds,
            $excludedProductIds
        );
    }

    public function getProductIdsByPid(
        $pid,
        $packTypes = array(
            \Akzo\Scheme\Data\Common\Product\PackType::RETAIL,
            \Akzo\Scheme\Data\Common\Product\PackType::BULK
        ),
        $projectSku
    )
    {
        // Check for All Products
        if (strcasecmp($pid, 'ALL') === 0) {
            $pid = 'P%';
        }

        return $this->_dao->loadProductIdsByPid($pid, $packTypes, $projectSku);
    }

    public function getProductsFromGroupByCode($code) {
        return $this->_dao->getProductsFromGroupByCode($code);
    }

    public function getProductsFromSubBrandByCode($code) {
        return $this->_dao->getProductsFromGroupByCode($code);
    }

    public function getProductsBySubBrandName($name)
    {
        try {
            $subBrand = $this->_dao->getSubBrandByName($name);
            return $this->_dao->getProductsFromSubBrand($subBrand);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function getProductsBySubBrandCode($code)
    {
        try {
            $subBrand = $this->_dao->getSubBrandByCode($code);
            return $this->_dao->getProductsFromSubBrand($subBrand);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    // public function searchProducts($token = null)
    // {
        
        
    // }

    public function getProductByName($name)
    {
        try {
            return $this->_dao->getProductByName($name);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function getProductByCode($code)
    {
        try {
            return $this->_dao->getProductByCode($code);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function getProductClusters($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllClusters();
            else
                return $this->_dao->searchClusters($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getProductSubBrands($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllSubBrands();
            else
                return $this->_dao->searchSubBrands($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getProductGroups($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllGroups();
            else
                return $this->_dao->searchGroups($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getProducts($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllProducts();
            else
                return $this->_dao->searchProducts($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getSubBrandsFromCluster($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllSubBrands();
            else
                return $this->_dao->getSubBrandsFromCluster($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getGroupsFromSubbrand($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllGroups();
            else
                return $this->_dao->getGroupsFromSubbrand($token);
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR,
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getProductsFromGroup($token = null) 
    {
        try {
            if($token == null)
                return $this->_dao->getAllProducts();
            else
                return $this->_dao->getProductsFromGroup($token);
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
