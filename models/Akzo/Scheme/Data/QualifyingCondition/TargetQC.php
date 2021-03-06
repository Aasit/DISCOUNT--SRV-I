<?php
namespace Akzo\Scheme\Data\QualifyingCondition;

class TargetQC extends BaseQC
    implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface,
        \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Qualifying Condition Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

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

        $this->period = clone $this->period;
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

        $data['period'] = $this->period->toRuleEngineData();
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
    
        // Read in the target value for the dealer for the products and period
        $vals = \Akzo\Sales\Service::getInstance()->getTargetData(
            $dealer,
            $this->segment,
            $this->period,
            $this->products
        );

        if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::VALUE) === 0) {
            $data['val'] = $vals['value'];
        } else {
            $data['val'] = $vals['volume'];
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
