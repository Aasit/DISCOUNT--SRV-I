<?php
namespace Akzo\Product;
use \Respect\Validation\Validator as v;

class DAOImpl extends \Native5\Db\BaseDbDAO implements \Akzo\Product\DAO
{
    // const QUERIES_FILE = 'queries.cfg.yml';

    public function __construct() {
        parent::__construct();
    }

    public function loadProductIdsByPid(
        $pid,
        $packTypes,
        $projectSku
    )
    {
        // Return an empty array if pack types are not present
        if (empty($packTypes)) {
            return array();
        }
        // Get the packType Ids
        $packTypeIds = $this->resolvePackTypeIds($packTypes);

        // The first character of the gid is type
        $pidType = substr($pid, 0, 1);
        // The rest is the code
        $code = substr($pid, 1);
        
        //To get IDs from db
        if ($projectSku) {
            $skuType = array(1,2);
        } else {
            $skuType = array(1);
        }
        
        
        if (strcmp($pidType, 'P') === 0) {  // Product
            return \Akzo\Product
                ::where('code', 'like', $code)
                ->whereIn('sku_type_id', $skuType)
                ->whereIn('pack_type_id', $packTypeIds)
                ->orderBy('id', 'ASC')
                ->lists('id');
        }
        
        if (strcmp($pidType, 'G') === 0) {  // Group
            $query = "\Akzo\Product\Group";
        } else if (strcmp($pidType, 'S') === 0) {  // Sub Brand
            $query = "\Akzo\Product\SubBrand";
        } else if (strcmp($pidType, 'C') === 0) {  // Cluster
            $query = "\Akzo\Product\Cluster";
        } else if (strcmp($pidType, 'B') === 0) {  // Brand
            $query = "\Akzo\Product\Brand";
        }

        return $query
            ::where('code', 'like', $code)
            ->get()
            ->first()
                ->products()
                ->whereIn('sku_type_id', $skuType)
                ->whereIn('pack_type_id', $packTypeIds)
                ->orderBy('id', 'ASC')
                ->lists('id');
    }

    public function resolvePackTypeIds($packTypes) {
        if (empty($packTypes)) {
            return array();
        }

        // Generate a mysql REGEXP with the provided packTypes
        $packTypesRegExp = implode('|', $packTypes);

        return \Akzo\Product\PackType
            ::where('type', 'REGEXP', $packTypesRegExp)
            ->lists('id');
    }

    /**
     * getProductByName Get one or more products by product name. products may have
     *                  same names.
     * 
     * @param string $name Product Name
     * @access public
     * @return array Returns an array of \Akzo\Product objects
     */
    public function getProductByName($name) {
        $this->_validate($name, "name");
        try {
            return \Akzo\Product
                ::orderBy('id', 'ASC')
                ->where('name', 'like', $name)
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
     * getProductByCode Get a product by unique product code
     * 
     * @param string $code Product Unique Code
     * @access public
     * @return object Returns an \Akzo\Product object
     */
    public function getProductByCode($code) {
        $this->_validate($code, "code");
        try {
            return \Akzo\Product
                ::where('code', 'like', $code)
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

    public function getProductsFromGroupByCode($code) {
        try {
            return \Akzo\Product\Group
                ::where('code', 'like', $code)
                ->orderBy('name', 'ASC')
                ->get()
                    ->products()
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
     * getAllProducts Get a list of all products
     * 
     * @access public
     * @return array Returns an array of \Akzo\Product objects
     */
    public function getAllProducts() {
        try {
            return \Akzo\Product
                ::orderBy('name', 'ASC')
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

    public function searchProducts($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Product
                ::where('code','like',$token)
                ->orWhere('name','like',$token)
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

    public function searchClusters($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Product\Cluster::with(
                array(
                    'brand',
                    'subbrands'
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

    /**
     * getAllSubBrands Get a list of all product subBrands
     * 
     * @access public
     * @return array Returns an array of \Akzo\Product\SubBrand objects
     */
    public function getAllSubBrands() {
        try {
            return \Akzo\Product\SubBrand
                ::orderBy('name', 'ASC')
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

    public function searchSubBrands($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Product\SubBrand::with(
                array(
                    'cluster',
                    'groups'
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

    public function getAllGroups() {
        try {
            return \Akzo\Product\Group::with(
                array(
                    'subBrand',
                    'products'
                )
            )->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
        
    }

    public function searchGroups($token) {
        $this->_validate($token, "token");
        $token = '%' . $token . '%';
        try {
            return \Akzo\Product\Group::with(
                array(
                    'subBrand',
                    'products'
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

    /**
     * getProductsFromSubBrand Get list of products from an \Akzo\Product\SubBrand object
     * 
     * @param \Akzo\Product\SubBrand $subBrand The subBrand object
     * @access public
     * @return array Returns array of \Akzo\Product objects
     */
    public function getProductsFromSubBrand(\Akzo\Product\SubBrand $subBrand) {
        try {
            return $subBrand
                ->products()
                    ->orderBy('name', 'ASC')
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
     * getSubBrandByName Get list of product subBrands by name. Sub Brands can have the same name.
     * 
     * @param mixed $name Product Sub Brand Name
     * @access public
     * @return array Returns an array for \Akzo\Product\SubBrand objects
     */
    public function getSubBrandByName($name) {
        $this->_validate($name, "name");
        try {
            return \Akzo\Product\SubBrand
                ::where('name', 'like', $name)
                ->orderBy('name', 'ASC')
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
     * getSubBrandByCode Get a product subBrands by code.
     * 
     * @param mixed $name Product Sub Brand Unique Code
     * @access public
     * @return object Returns an \Akzo\Product\SubBrand object
     */
    public function getSubBrandByCode($code) {
        $this->_validate($code, "code");
        try {
            return \Akzo\Product\SubBrand
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

    /**
     * getAllClusters Get a list of all product clusters
     * 
     * @access public
     * @return array Returns an array of \Akzo\Product\Cluster objects
     */
    public function getAllClusters() {
        try {
            return \Akzo\Product\Cluster
                ::orderBy('name', 'ASC')
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
    public function getProductsFromCluster(\Akzo\Product\Cluster $cluster) 
    {
        try {
            return $cluster->products()->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getSubBrandsFromCluster($token)
    {
        $this->_validate($token, "token");
        try {
            if($token == null)
                return $this->getAllSubBrands();
            else {
                $token = '%' . $token . '%';
                $cluster = \Akzo\Product\Cluster::where('code','like',$token)->orWhere('name','like',$token)->get()->first();
                return $cluster->subbrands()->get()->all();
            }        
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getGroupsFromSubbrand($token)
    {
        $this->_validate($token, "token");
        try {

            $token = '%' . $token . '%';
            $subbrand = \Akzo\Product\SubBrand::where('code','like',$token)->orWhere('name','like',$token)->get()->first();
            return $subbrand->groups()->get()->all();
            
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getProductsFromGroup($token)
    {
        $this->_validate($token, "token");
        try {
            if($token == null)
                return $this->getAllProducts();
            else {
                $token = '%' . $token . '%';
                $group = \Akzo\Product\Group::where('code','like',$token)->orWhere('name','like',$token)->get()->first();
                return $group->products()->get()->all();
            }        
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


        if(strcmp($type, "name") === 0) {
            $isValid = $validateName->validate($param);
            if (!$isValid) {
                throw new \InvalidArgumentException(
                    \Akzo\Product\ErrorMessages::INVALID_PRODUCT_NAME, 
                    \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
                );
            }
        }

        else if (strcmp($type, "code") === 0) {
            $isValid = $validateCode->validate($param);
            if (!$isValid) {
                throw new \InvalidArgumentException(
                    \Akzo\Product\ErrorMessages::INVALID_PRODUCT_CODE, 
                    \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
                );
            }
        }
        
        else if (strcmp($type, "token") === 0) {
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
