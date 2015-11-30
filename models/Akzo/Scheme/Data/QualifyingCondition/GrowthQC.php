<?php
namespace Akzo\Scheme\Data\QualifyingCondition;

class GrowthQC extends BaseQC
    implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface,
        \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Qualifying Condition Current Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $currentPeriod;

    /**
     * Qualifying Condition Previous Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $previousPeriod;

    /**
     * Qualifying Condition Products
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $products;

    /**
     * Custom cloning for this class
     */
    public function __clone() {
        $this->name = clone $this->name;
        $this->type = clone $this->type;
        $this->op = clone $this->op;

        $this->currentPeriod = clone $this->currentPeriod;
        $this->previousPeriod = clone $this->previousPeriod;

        $products = array();
        foreach ($this->products as $idx=>$product) {
            $products[] = clone $product;
        }
        $this->products = $products;
    }

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = parent::toRuleEngineData();

        $data['currentPeriod'] = $this->currentPeriod->toRuleEngineData();
        $data['previousPeriod'] = $this->previousPeriod->toRuleEngineData();

        $data['products'] = array();
        foreach ($this->products as $idx=>$product) {
            $data['products'][] = $product->toRuleEngineData();
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    /**
     * Rule Engine Execution Data Generator for a Dealer
     * 
     * @param \Akzo\Dealer $dealer Dealer for which to generate execution data
     * @param boolean $format none | json
     */
    public function toRuleEngineDealerExecData(\Akzo\Dealer $dealer, $executionDataType, $format = 'none') {
        $data = parent::toRuleEngineDealerExecData($dealer, $executionDataType, 'none');
    
        // Read in the sales value for the dealer for the products and current Period
        $currentVals = \Akzo\Sales\Service::getInstance()->getSalesData(
            $dealer,
            $this->segment,
            $this->currentPeriod,
            $this->products
        );

        // Read in the sales value for the dealer for the products and Period
        $previousVals = \Akzo\Sales\Service::getInstance()->getSalesData(
            $dealer,
            $this->segment,
            $this->previousPeriod,
            $this->products
        );

        if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::VALUE) === 0) {
            $data['currentVal'] = $currentVals['value'];
            $data['previousVal'] = $previousVals['value'];
        } else {
            $data['currentVal'] = $currentVals['volume'];
            $data['previousVal'] = $previousVals['volume'];
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
