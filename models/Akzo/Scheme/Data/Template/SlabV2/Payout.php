<?php
namespace Akzo\Scheme\Data\Template\SlabV2;

class Payout implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Payout Id
     * @var string
     */
    public $id;

    /**
     * Products for this payout
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $products;

    /**
     * Payout Slab Start
     * @var float
     */
    public $slabStartValue;

    /**
     * Payout Value for this row
     * @var float
     */
    public $payoutValue;

    /**
     * Payout Type for this row
     * @var \Akzo\Scheme\Data\Common\PayoutType
     */
    public $payoutType;

    /**
     * Product Pack Types for this template
     * @var array
     */
    public $packs;

    /**
     * Slab Level Qualifying Condition Satisfy All / Any
     * @var boolean
     */
    public $satisfyAll;

    /**
     * Slab Level Qualifying Conditions List
     * @param array List of Qualifying Conditions
     */
    public function setQcList($qcList) {
        $mapper = new \JsonMapper();
        $this->qcList = array();

        if (empty($qcList)) {
            return;
        }

        foreach($qcList as $idx=>$qc) {
            if (is_array($qc)) {
                $qcName = $qc['name'];
            } else if (isset($qc->name)) {
                $qcName = $qc->name;
            } else {
                // An empty object
                continue;
            }

            if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::HISTORICAL) === 0) {
                $this->qcList[] = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\HistoricalQC());
            } else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::GROWTH) === 0) {
                $this->qcList[] = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\GrowthQC());
            } else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::ACTUAL) === 0) {
                $this->qcList[] = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\ActualQC());
            } else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::TARGET) === 0) {
                $this->qcList[] = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\TargetQC());
            } else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::TARGET_ACHIEVEMENT) === 0) {
                $this->qcList[] = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\TargetAchievementQC());
            } else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::RATIO) === 0) {
                $this->qcList[] = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\RatioQC());
            }
        }
    }

    /**
     * Slab Level Qualifying Condition
     * @param object Qualifying Condition
     */
    //public function setQc($qc) {
        //$mapper = new \JsonMapper();
        //$this->qc = array();

        //if (empty($qc)) {
            //return;
        //}

        //if (is_array($qc)) {
            //$qcName = $qc['name'];
        //} else if (isset($qc->name)) {
            //$qcName = $qc->name;
        //} else {
            //// An empty object
            //return;
        //}

        //if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::HISTORICAL) === 0) {
            //$this->qc = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\HistoricalQC());
        //} else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::GROWTH) === 0) {
            //$this->qc = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\GrowthQC());
        //} else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::ACTUAL) === 0) {
            //$this->qc = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\ActualQC());
        //} else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::TARGET) === 0) {
            //$this->qc = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\TargetQC());
        //} else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::TARGET_ACHIEVEMENT) === 0) {
            //$this->qc = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\TargetAchievementQC());
        //} else if (strcasecmp($qcName, \Akzo\Scheme\Data\QualifyingCondition\Type::RATIO) === 0) {
            //$this->qc = $mapper->map($qc, new \Akzo\Scheme\Data\QualifyingCondition\RatioQC());
        //}
    //}

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['products'] = $this->_condenseProductsPid();
        $data['slabStartValue'] = $this->slabStartValue;
        $data['payoutValue'] = $this->payoutValue;
        $data['payoutType'] = $this->payoutType->getValue();
        $data['packs'] = $this->packs;
        if (isset($this->qcList) && !empty($this->qcList)) {
            foreach ($this->qcList as $idx=>$qc) {
                $data['qcList'][] = $qc->toRuleEngineData();
            }
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    private function _condenseProductsPid() {
        $data = array();
        $data[0] = array();
        $data[0]['pid'] = \Akzo\Scheme\Utils::condenseProductsPid($this->products);

        return $data;
    }
}
