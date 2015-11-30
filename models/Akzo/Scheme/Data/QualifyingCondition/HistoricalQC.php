<?php
namespace Akzo\Scheme\Data\QualifyingCondition;

class HistoricalQC extends TargetQC
    implements \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Rule Engine Execution Data Generator for a Dealer
     * 
     * @param \Akzo\Dealer $dealer Dealer for which to generate execution data
     * @param boolean $format none | json
     */
    public function toRuleEngineDealerExecData(\Akzo\Dealer $dealer, $executionDataType, $format = 'none') {
        $data = parent::toRuleEngineDealerExecData($dealer, $executionDataType, 'none');
    
        // Read in the sales value for the dealer for the products and period
        $vals = \Akzo\Sales\Service::getInstance()->getSalesData(
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
