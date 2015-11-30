<?php
namespace Akzo\Scheme\ExecData;

class InBillEntry implements \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
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
     * Consolidated Products for this InBill Entry
     * @var \Akzo\Scheme\ExecData\Common\Product
     */
    public $product;

    /**
     * Product Pack Types for this InBill Entry
     * @var array
     */
    public $packs;

    /**
     * Product SKU for this InBill Entry
     * @var bool
     */
    public $projectSku;

    /**
     * Scheme Sales Segments Applicable
     * @var array
     */
    public $segment;

    /**
     * Value number for this InBill Entry
     * @var float
     */
    public $value;

    /**
     * Volume number for this InBill Entry
     * @var float
     */
    public $volume;

    /**
     * Quantity as per type for this InBill Entry
     * @var float
     */
    public $qty;

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
        // Condense the products pid into a single product pid array
        $data['product'] = $this->_condenseProductsPid();
        $data['packs'] = $this->packs;
        $data['projectSku'] = $this->projectSku;

        // Plugin the value / volume / qty data
        $vals = $this->_getSalesTargetData($dealer, $executionDataType);
        $data['value'] = $vals['value'];
        $data['volume'] = $vals['volume'];
        // For inBillEntries qty is same as volume
        $data['qty'] = $vals['volume'];

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    private function _condenseProductsPid() {
        $data = array();
        $data['pid'] = \Akzo\Scheme\Utils::condenseProductsPid($this->product);

        return $data;
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
                $this->product,
                $this->projectSku

            )
        );
    }
}
