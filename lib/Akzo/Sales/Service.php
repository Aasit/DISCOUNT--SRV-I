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

namespace Akzo\Sales;
use \Respect\Validation\Validator as v;

/**
 * Service Akzo Sales
 *
 * @category Class
 * @package  Akzo\Sales
 * @author   Anurag Dadheech <anurag.dadheech@native5.com>
 * @license  See attached LICENSE for details
 * @link     http://www.docs.native5.com 
 *
 */
class Service
{
    protected $dao;
    protected $logger;
    protected $app;
    protected $cache;

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
        $this->logger = $GLOBALS['logger'];
        $this->app = $GLOBALS['app'];
        $this->dao = new \Akzo\Sales\DAOImpl();
        $this->cache = new \Native5\Core\Caching\Cache(\Native5\Core\Caching\SimpleCache::instance());
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

    public function getSalesData(
        \Akzo\Dealer $dealer,
        $segments,
        $period,
        $products,
        $projectSku,
        $packTypes = array(
            \Akzo\Scheme\Data\Common\Product\PackType::RETAIL,
            \Akzo\Scheme\Data\Common\Product\PackType::BULK
        )
    )
    {
        return $this->dao->loadSalesData(
            $dealer,
            $period->startDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT),
            $period->endDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT),
            $this->_convertProductsToIds($products, $packTypes, $projectSku),
            $segments
        );
    }

    public function getTargetData(
        \Akzo\Dealer $dealer,
        $segments,
        $period,
        $products,
        $projectSku,
        $packTypes = array(
            \Akzo\Scheme\Data\Common\Product\PackType::RETAIL,
            \Akzo\Scheme\Data\Common\Product\PackType::BULK
        )
    )
    {
        return $this->dao->loadTargetData(
            $dealer,
            $period->startDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT),
            $period->endDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT),
            $this->_convertProductsToIds($products, $packTypes, $projectSku),
            $segments
        );
    }

    private function _convertProductsToIds($products, $packs, $projectSku) {
        $productsKey = '_PRODUCT_'.\Akzo\Scheme\Utils::condenseProductsPid($products);

        // Check if the converted ids are in the cache already
        if ($this->cache->exists($productsKey)) {
            //$GLOBALS['logger']->info('Got productsKey in cache - '.$productsKey);
            return $this->cache->get($productsKey);
        }

        //$GLOBALS['logger']->info('Did not get productsKey in cache - '.$productsKey);

        // Translate products list to product ids
        $translatedIds = \Akzo\Product\Service::getInstance()
            ->transformProductsToIds($products, $projectSku, $packs);

        // Set it in cache
        $this->cache->set($productsKey, $translatedIds);

        $GLOBALS['logger']->info('Prod IDS length: '.sizeof($translatedIds));
        return $translatedIds;
    }

    public function getSalesDataByDealerObjects($data) 
    {
        try {
            $dealerCodes = array();
            foreach ($data as $value) {
                if(!($value instanceof Akzo\Dealer))
                    return false;
                else{
                    array_push($dealerCodes, $value->code);
                }
            }
            return $this->getSalesDataByDealerCodes($dealerCodes);
        } catch (\PDOException $e) {
            $this->logger->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getSalesDataByDealerCodes($data) 
    {
        try {
            return $this->dao->getSalesDataByDealerCodes($data);
        } catch (\PDOException $e) {
            $this->logger->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function loadSalesDataFromDealerIDs($dealerIDs, $period) 
    {
        try {
            return $this->dao->loadSalesDataFromDealerIDs($dealerIDs, $period);
        } catch (\PDOException $e) {
            $this->logger->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function loadSalesDataFromDealer(\Akzo\Dealer $dealer, $period) 
    {
        try {
            return $this->dao->loadSalesDataFromDealer($dealer, $period);
        } catch (\PDOException $e) {
            $this->logger->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getSalesTargetsByDealerObjects($data) 
    {
        try {
            $dealerCodes = array();
            foreach ($data as $value) {
                if(!($value instanceof Akzo\Dealer))
                    return false;
                else{
                    array_push($dealerCodes, $value->code);
                }
            }
            return $this->getSalesTargetsByDealerCodes($dealerCodes);
        } catch (\PDOException $e) {
            $this->logger->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getSalesTargetsByDealerCodes($data) 
    {
        try {
            return $this->dao->getSalesTargetsByDealerCodes($data);
        } catch (\PDOException $e) {
            $this->logger->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    private function _validate($param, $type)
    {

        $libConfig = $this->app->getConfiguration()->getRawConfiguration('library');
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
