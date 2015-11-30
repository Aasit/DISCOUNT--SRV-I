<?php
namespace Akzo\Scheme\ExecData;

class ProductEntry implements \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Template/Lap Id
     * @var string
     */
    public $tplId;

    /**
     * Template/Lap Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

    /**
     * Consolidated Products for this Product Entry
     * @var \Akzo\Scheme\ExecData\Common\Product
     */
    public $product;

    /**
     * Scheme Sales Segments Applicable
     * @var array
     */
    public $segment;

    /**
     * Product SKU
     * @var bool
     */
    public $projectSku;

    /**
     * Quantity Type for this template
     * @var \Akzo\Scheme\Data\Common\QuantityType
     */
    public $type;

    /**
     * Value number for this Product Entry
     * @var float
     */
    public $value;

    /**
     * Volume number for this Product Entry
     * @var float
     */
    public $volume;

    /**
     * Quantity as per type for this Product Entry
     * @var float
     */
    public $qty;

    /**
     * The qcList for this Product Entry
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
        $data['product'] = $this->product;
        $data['projectSku'] = $this->projectSku;

        // Plugin the value / volume / qty data
        $vals = $this->_getSalesTargetData($dealer, $executionDataType);
        $data['value'] = $vals['value'];
        $data['volume'] = $vals['volume'];
        // Plugin the qty as per the lap Entry type
        if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::VALUE) === 0) {
            $data['qty'] = $vals['value'];
        } else {
            $data['qty'] = $vals['volume'];
        }

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

    private function _getSalesTargetData(\Akzo\Dealer $dealer, $executionDataType) {
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
                array($this->product),
                $this->projectSku
            )
        );
    }
}