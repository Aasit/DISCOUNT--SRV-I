<?php
namespace Akzo\Scheme\Data\QualifyingCondition;

class BaseQC
    implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface,
        \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Qualifying Condition Id
     * @var string
     */
    public $qid;

    /**
     * Qualifying Condition Type
     * @var \Akzo\Scheme\Data\QualifyingCondition\Type
     */
    public $name;

    /**
     * Qualifying Condition Quantity Type
     * @var \Akzo\Scheme\Data\Common\QuantityType
     */
    public $type;

    /**
     * Qualifying Condition Comparison Operator
     * @var \Akzo\Scheme\Data\QualifyingCondition\Operator
     */
    public $op;

    /**
     * Qualifying Condition Comparison Value
     * @var float
     */
    public $val;

    /**
     * Qualifying Condition Payout Percentage
     * @var float
     */
    public $payoutCondition;

    /**
     * Scheme Sales Segments Applicable
     * @var array
     */
    public $segment;

    /**
     * Custom cloning for this class
     */
    public function __clone() {
        $this->name = clone $this->name;
        $this->type = clone $this->type;
        $this->op = clone $this->op;
    }

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['qid'] = $this->qid;
        $data['name'] = $this->name->getValue();
        $data['type'] = $this->type->getValue();
        $data['op'] = $this->op->getValue();
        $data['val'] = $this->val;
        $data['payoutCondition'] = $this->payoutCondition/100;

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
        $data = array();

        $data['qid'] = $this->qid;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

