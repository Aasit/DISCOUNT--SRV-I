<?php
namespace Akzo\Scheme\ExecData;

class LapEntry implements \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Lap Template Id
     * @var string
     */
    public $tplId;

    /**
     * Lap Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

    /**
     * Lap previous Period
     * @var \Akzo\Scheme\Data\Common\PreviousPeriod
     */
    public $previousPeriod;

    /**
     * Lap Current Period
     * @var \Akzo\Scheme\Data\Common\CurrentPeriod
     */
    public $currentPeriod;

    /**
     * Consolidated Products for this Lap Entry
     * @var \Akzo\Scheme\ExecData\Common\Product[]
     */
    public $products;

    /**
     * Consolidated payout Products for this Lap Entry
     * @var \Akzo\Scheme\ExecData\Common\Product[]
     */
    public $payoutProducts;

    /**
     * Product Pack Types for this Lap Entry
     * @var array
     */
    public $packs;

    /**
     * Product SKU for this Lap Entry
     * @var bool
     */
    public $projectSku;

    /**
     * Scheme Sales Segments Applicable
     * @var array
     */
    public $segment;

    /**
     * Quantity Type for this template
     * @var \Akzo\Scheme\Data\Common\QuantityType
     */
    public $type;

    /**
     * Value number for this Lap Entry
     * @var float
     */
    public $value;

    /**
     * Volume number for this Lap Entry
     * @var float
     */
    public $volume;

    /**
     * Quantity as per type for this Lap Entry
     * @var float
     */
    public $qty;

    /**
     * The qcList for this Lap Entry
     * @var array
     */
    public $qcList;

    /**
     * Rule Engine Execution Data Generator for a Dealer
     * 
     * @param \Akzo\Dealer $dealer Dealer for which to generate execution data
     * @param boolean $format none | json
     */
    public function toRuleEngineDealerExecData(\Akzo\Dealer $dealer, $executionDataType, $format = 'none') {
        $data = array();

        // Plugin lap entry data
        $data['tplId'] = $this->tplId;
        $data['period'] = $this->period->toRuleEngineData();
        if (!empty($this->currentPeriod) && $this->currentPeriod instanceof \Akzo\Scheme\Data\Common\Period) {
            $data['currentPeriod'] = $this->currentPeriod->toRuleEngineData();
        }   
        if (!empty($this->previousPeriod) && $this->previousPeriod instanceof \Akzo\Scheme\Data\Common\Period) {
            $data['previousPeriod'] = $this->previousPeriod->toRuleEngineData();
        }
            
        //curr period & previous period
        // Condense the products pid into a single product pid array
        $data['products'] = $this->_condenseProductsPid($this->products);
        
        $data['packs'] = $this->packs;
        $data['projectSku'] = $this->projectSku;

        if(isset($this->payoutProducts) && !empty($this->payoutProducts)) {
            $data['payoutProducts'] = $this->_condenseProductsPid($this->payoutProducts);
            $payoutVals = $this->_getSalesTargetData($dealer, $executionDataType, $this->payoutProducts);
        }

        // Plugin the value / volume / qty data
        $vals = $this->_getSalesTargetData($dealer, $executionDataType, $this->products);
        
        // Plugin the qty as per the lap Entry type
        if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::VALUE) === 0) {
            $data['qty'] = $vals['value'];
        } else if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::VOLUME) === 0) {
            $data['qty'] = $vals['volume'];
        } else if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::GROWTH) === 0) {
            $prevSalesData = \Akzo\Sales\Service::getInstance()->loadSalesDataFromDealer(
                $dealer, $data['previousPeriod']
            );
            $currSalesData = \Akzo\Sales\Service::getInstance()->loadSalesDataFromDealer(
                $dealer, $data['currentPeriod']
            );
            $data['qty'] = (($currSalesData['value']/$prevSalesData['value'])-1)*100;
        }

        if(isset($data['payoutProducts']) && !empty($data['payoutProducts'])) {
            $data['value'] = $payoutVals['value'];
            $data['volume'] = $payoutVals['volume'];
        }
        else {
            $data['value'] = $vals['value'];
            $data['volume'] = $vals['volume'];
        }

        //third one with getsalesdata(prevPeriod) and getsalesdata(currPeriod) and get growth percentage a/b*100 from there

        // Add the qcList execution data
        $data['qcList'] = array();
        foreach ($this->qcList as $idx=>$qc) {
            $data['qcList'][] = $qc->toRuleEngineDealerExecData($dealer, $executionDataType, 'none');
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    private function _condenseProductsPid($products) {
        $data = array();
        $data[0] = array();
        $data[0]['pid'] = \Akzo\Scheme\Utils::condenseProductsPid($products);

        return $data;
    }

    private function _getSalesTargetData(\Akzo\Dealer $dealer, $executionDataType, $prods) {
        // Function for execution differs based on execution data type
        $funcToExec = 'getTargetData';
        if (strcasecmp($executionDataType, \Akzo\Scheme\ExecuteActionDataType::ACTUAL) === 0
                || strcasecmp($executionDataType, \Akzo\Scheme\ExecuteActionDataType::HISTORICAL) === 0) {
            $funcToExec = 'getSalesData';
        }

        // Read in the sales value for the dealer for the products and period
        return call_user_func_array(
            array(
                \Akzo\Sales\Service::getInstance(),
                $funcToExec
            ),
            array(
                $dealer,
                $this->segment,
                $this->period,
                $prods,
                $this->projectSku,
                $this->packs
                
            )
        );
    }
}

