<?php
namespace Akzo\Sales;
use \Respect\Validation\Validator as v;

class DAOImpl extends \Native5\Db\BaseDbDAO implements \Akzo\Sales\DAO
{
    // const QUERIES_FILE = 'queries.cfg.yml';

    public function __construct() {
        parent::__construct();
        // Load the sql queries file
        // parent::loadQueries(__DIR__.DIRECTORY_SEPARATOR.self::QUERIES_FILE);
    }

    public function loadSalesData(\Akzo\Dealer $dealer, $startDate, $endDate, $productIds, $segments = array()) {
        if (empty($dealer)) {
            return array(
                'value' => 0,
                'volume' => 0
            );
        }
        $excludedSegment = "74 Professional";
        // $GLOBALS['logger']->info("segments: ".print_r($segments,1));

        // If data is collated read data by colladed ids for credit code, else collate by dealer code
        if (isset($dealer->cids) && !empty($dealer->cids)) {
            $query = \Akzo\Sales\Data
                ::whereIn(
                    'dealer_id',
                    explode(',', $dealer->cids)
                );
        } else {
            $query = $dealer
                ->salesData();
        }

        if(in_array($excludedSegment, $segments)) {
            $query = $query
                ->whereBetween(
                    'date',
                    array(
                        $startDate,
                        $endDate
                    )
                )
                ->whereIn(
                    'product_id',
                    $productIds
                );

        }

        else {
            // $GLOBALS['logger']->info("Has prof slaes");

            $excludedSegmentID = $this->getIDBySegment($excludedSegment);
            $query = $query
                ->whereBetween(
                    'date',
                    array(
                        $startDate,
                        $endDate
                    )
                )
                ->whereIn(
                    'product_id',
                    $productIds
                )
                ->where('division_id', '!=', $excludedSegmentID);

        }

            
        // TODO: Optimize this, the same query run twice with different sums
        return array(
            'value' => $query->sum('value'),
            'volume' => $query->sum('quantity')
        );
    }

    public function loadTargetData(\Akzo\Dealer $dealer, $startDate, $endDate, $productIds, $segments = array()) {
        if (empty($dealer)) {
            return array(
                'value' => 0,
                'volume' => 0
            );
        }
        $excludedSegment = "74 Professional";
        // $GLOBALS['logger']->info("segments: ".print_r($segments,1));

        // If dealer contains collated ids read data by colladed ids for credit code, else collate by dealer code
        if (isset($dealer->cids) && !empty($dealer->cids)) {
            $query = \Akzo\Sales\Data
                ::whereIn(
                    'dealer_id',
                    explode(',', $dealer->cids)
                );
        } else {
            $query = $dealer
                ->salesTargets();
        }

        // Add where clauses for date range and product ids
        $query = $query
            ->whereBetween(
                'date',
                array(
                    $startDate,
                    $endDate
                )
            )
            ->whereIn(
                'product_id',
                $productIds
            );

        // If the excludedSegment is not set, then need to exclude it
        if (!in_array($excludedSegment, $segments)) {
            // $GLOBALS['logger']->info("Has prof");
            $excludedSegmentID = $this->getIDBySegment($excludedSegment);
            $query = $query
                ->where(
                    'division_id',
                    '!=',
                    $excludedSegmentID
                );

        }

        // TODO: Optimize this, the same query run twice with different sums
        return array(
            'value' => $query->sum('value'),
            'volume' => $query->sum('quantity')
        );
    }

    public function loadSalesDataFromDealerIDs($dealerIDs, $period) {
        $query = \Akzo\Sales\Data
            ::whereBetween(
                'date',
                array(
                    $period['startDate'],
                    $period['endDate']
                )
            )
            ->whereIn(
                'dealer_id',
                $dealerIDs
            );

            return array(
                'value' => $query->sum('value'),
                'volume' => $query->sum('quantity')
            );
    }

    public function loadSalesDataFromDealer(\Akzo\Dealer $dealer, $period) {
        $query = \Akzo\Sales\Data
            ::whereBetween(
                'date',
                array(
                    $period['startDate'],
                    $period['endDate']
                )
            )
            ->where(
                'dealer_id',
                'like',
                $dealer->id
            );

            return array(
                'value' => $query->sum('value'),
                'volume' => $query->sum('quantity')
            );
    }

    //private function _dateTimeDiff($start, $end) {
        //// Create PHP DateTime objects for easy manipulation
        //$startDT = \DateTime::createFromFormat(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT, $start); 
        //$endDT = \DateTime::createFromFormat(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT, $end);

        //// Difference in number of months
        //$monthsDiff = $startDT->diff($endDT)->m + ($startDT->diff($endDT)->y*12);

        //// Translate start/end dates corresponding month / year
        //$dateStart = $startDT->format('d');
        //$monthStart = $startDT->format('m');
        //$yearStart = $startDT->format('Y');
        //$dateEnd = $endDT->format('d');
        //$monthEnd = $endDT->format('m');
        //$yearEnd = $endDT->format('Y');

        //$periods = array();
        //for($m = $monthStart, $y = $yearStart, $i = 0; $i <= $monthsDiff; $m++, $i++) {
            //if ($i == 0) {
                //if ($monthsDiff == 0) {
                    //$periods[
                        //$this->_loadMonthYearId($y.str_pad($m, 2, "0", STR_PAD_LEFT))
                    //] = $this->_calculateDateMonthRatio($dateStart, $dateEnd);
                //} else {
                    //$periods[
                        //$this->_loadMonthYearId($y.str_pad($m, 2, "0", STR_PAD_LEFT))
                    //] = $this->_calculateDateMonthRatio($dateStart);
                //}
            //} else if ($i == $monthsDiff) {
                //$periods[
                    //$this->_loadMonthYearId($y.str_pad($m, 2, "0", STR_PAD_LEFT))
                //] = $this->_calculateDateMonthRatio(null, $dateEnd);
            //} else {
                //$periods[
                    //$this->_loadMonthYearId($y.str_pad($m, 2, "0", STR_PAD_LEFT))
                //] = 1;
            //}

            //// Roll over month, year
            //if ((int)$m == 12) {
                //$m = 0;
                //$y++;
            //}
        //}

        //return $periods;
    //}

    //private function _calculateDateMonthRatio($dateStart, $dateEnd = null) {
        //// Convert strings to integers
        //$dateStart = (int)$dateStart;
        //$dateEnd = (int)$dateEnd;

        //// Calculate Ratio
        //if (!empty($dateStart) && empty($dateEnd)) {
            //return (30 - $dateStart)/30;
        //} else if (empty($dateStart) && !empty($dateEnd)) {
            //return $dateEnd/30;
        //} else {
            //return ($dateEnd - $dateStart)/30;
        //}
    //}

    //private function _loadMonthYearId($monthYear) {
        //return \Akzo\Sales\MonthYear
            //::where('yyyymm', 'like', $monthYear)
            //->get()
            //->first()
            //->ID;
    //}

    //// TODO: Change this to a private function
    //// FIXME: Remove this from here and transfer to scheme execution
    //public function _transformPeriodToMonthPercentages($period) {
        //$dateStart = \DateTime::createFromFormat(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT, $period['startDate']); 
        //$dateEnd = \DateTime::createFromFormat(\Akzo\Scheme\Data\Common\DateTimeFormat::STORAGE_FORMAT, $period['endDate']);

        //// Translate start/end dates corresponding month / year
        //$dateStart = $dateStart->format('d');
        //$monthStart = $dateStart->format('m');
        //$yearStart = $dateStart->format('Y');
        //$dateEnd = $dateEnd->format('d');
        //$monthEnd = $dateEnd->format('m');
        //$yearEnd = $dateEnd->format('Y');

        //// Read ids from ak_sales_monthyear table
        //if (strcmp($monthStart.$yearStart, $monthEnd.$yearEnd) === 0) {
            //// Both the dates in one monthyear
            //return array(
                //$this->_loadMonthYearId(
                    //$monthStart,
                    //$yearStart
                //)
                //=> $this->_calculateDateMonthRatio(
                   //$dateStart,
                   //$dateEnd
                //)
            //);
        //} else {
            //// Get the months and their corresponding ratios
            

            //// Need to get both month year and divide into percentages
            //return array(
                //$this->_loadMonthYearId(
                    //$monthStart,
                    //$yearStart
                //)
                //=> 1,
                //$this->_loadMonthYearId(
                    //$monthEnd,
                    //$yearEnd
                //)
                //=> 1
            //);

        //}
    //}

    public function getSalesDataByDealerCodes($data)
    {
        try {
            return \Akzo\Dealer::with(
                array(
                    'salesData'
                )
            )->whereIn('code', $data)->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getSalesTargetsByDealerCodes($data)
    {
        try {
            return \Akzo\Dealer::with(
                array(
                    'salesTargets'
                )
            )->whereIn('code', $data)->get()->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }


    private function getIDBySegment($segment)
    {
        try {
            $vertical = \Akzo\Sales\Vertical::where('segment', 'like', $segment)->get()->first();
            return $vertical->ID;
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
