<?php
namespace Akzo\Scheme\Data\QualifyingCondition;

class RatioQC extends BaseQC
    implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface,
        \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Qualifying Condition Numerator Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $numPeriod;

    /**
     * Qualifying Condition Denominator Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $denPeriod;

    /**
     * Qualifying Condition Numerator Products
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $numProducts;

    /**
     * Qualifying Condition Denominator Products
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $denProducts;

    /**
     * Custom cloning for this class
     */
    public function __clone() {
        $this->name = clone $this->name;
        $this->type = clone $this->type;
        $this->op = clone $this->op;

        $this->denPeriod = clone $this->denPeriod;
        $this->denPeriod = clone $this->denPeriod;

        $products = array();
        foreach ($this->denProducts as $idx=>$product) {
            $products[] = clone $product;
        }
        $this->denProducts = $products;

        $products = array();
        foreach ($this->numProducts as $idx=>$product) {
            $products[] = clone $product;
        }
        $this->numProducts = $products;
    }

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = parent::toRuleEngineData();

        $data['numPeriod'] = $this->numPeriod->toRuleEngineData();
        $data['denPeriod'] = $this->denPeriod->toRuleEngineData();

        $data['numProducts'] = array();
        foreach ($this->numProducts as $idx=>$product) {
            $data['numProducts'][] = $product->toRuleEngineData();
        }

        $data['denProducts'] = array();
        foreach ($this->denProducts as $idx=>$product) {
            $data['denProducts'][] = $product->toRuleEngineData();
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
    
        // Read in the sales value for the dealer for the numerator Products and period
        $numVals = \Akzo\Sales\Service::getInstance()->getSalesData(
            $dealer,
            $this->segment,
            $this->numPeriod,
            $this->numProducts
        );

        // Read in the target value for the dealer for the Denominator Products and period
        $denVals = \Akzo\Sales\Service::getInstance()->getSalesData(
            $dealer,
            $this->segment,
            $this->denPeriod,
            $this->denProducts
        );

        if (strcasecmp($this->type->getValue(), \Akzo\Scheme\Data\Common\QuantityType::VALUE) === 0) {
            $data['numVal'] = $numVals['value'];
            $data['denVal'] = $denVals['value'];
        } else {
            $data['numVal'] = $numVals['volume'];
            $data['denVal'] = $denVals['volume'];
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
