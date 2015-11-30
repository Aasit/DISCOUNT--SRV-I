<?php
namespace Akzo\Scheme\Data;

class HeaderTemplate implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Scheme Id
     * @var string
     */
    public $id;

    /**
     * Scheme Header
     * @var \Akzo\Scheme\Data\HeaderTemplate\Header
     */
    public $schemeHeader;

    /**
     * Scheme Top Level Qualifying Condition Satisfy All / Any
     * @var boolean
     */
    public $satisfyAll;

    /**
     * Scheme Top Level Qualifying Conditions List
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
            } else {
                $qcName = $qc->name;
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
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['schemeHeader'] = $this->schemeHeader->toRuleEngineData();
        $data['satisfyAll'] = $this->satisfyAll;

        $data['qcList'] = array();
        foreach ($this->qcList as $idx=>$qc) {
            $data['qcList'][] = $qc->toRuleEngineData();
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

