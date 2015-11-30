<?php
namespace Akzo\Scheme;

class ExecData implements \Akzo\Scheme\Common\RuleEngineExecDataGeneratorInterface
{
    /**
     * Scheme Id for Execution
     * @var string
     */
    public $sid;

    // TODO: Are these used during execution, remove
    /**
     * Scheme Start Date
     * @var \DateTime
     */
    public $startDate;

    // TODO: Are these used during execution, remove
    /**
     * Scheme End Date
     * @var \DateTime
     */
    public $endDate;

    // TODO: Ask to return dealer back in the execution results for correlation
    /**
     * Dealer Identifier
     * @var string
     */
    public $dealer;

    // TODO: Not required remove depot
    /**
     * Depot Identifier
     * @var string
     */
    public $depot = '__DEPOT_ID__';

    // TODO: Not required remove dealerAttribute
    /**
     * Dealer Attribute
     * @var array
     */
    public $dealerAttribute = array( 'A' );

    /**
     * Scheme Top-Level & Template-Level Historical QC List
     * @var \Akzo\Scheme\Data\QualifyingCondition\HistoricalQC[]
     */
    public $historicals;

    /**
     * Scheme Top-Level & Template-Level Growth QC List
     * @var \Akzo\Scheme\Data\QualifyingCondition\GrowthQC[]
     */
    public $growths;

    /**
     * Scheme Top-Level & Template-Level Actual QC List
     * @var \Akzo\Scheme\Data\QualifyingCondition\ActualQC[]
     */
    public $actuals;

    /**
     * Scheme Top-Level & Template-Level Target QC List
     * @var \Akzo\Scheme\Data\QualifyingCondition\TargetQC[]
     */
    public $targets;

    /**
     * Scheme Top-Level & Template-Level Target Achievement QC List
     * @var \Akzo\Scheme\Data\QualifyingCondition\TargetAchievementQC[]
     */
    public $targetAchievements;

    /**
     * Scheme Top-Level & Template-Level Ratio QC List
     * @var \Akzo\Scheme\Data\QualifyingCondition\RatioQC[]
     */
    public $ratios;

    /**
     * Scheme Lap Based Template's Execution Data
     * @var \Akzo\Scheme\ExecData\LapEntry[]
     */
    public $lapEntries;

    /**
     * Scheme Product Based Template's Execution Data
     * @var \Akzo\Scheme\ExecData\ProductEntry[]
     */
    public $productEntries;

    /**
     * Scheme InBill Product Based Template's Execution Data
     * @var \Akzo\Scheme\ExecData\InBillEntry[]
     */
    public $inBillEntries;

    /**
     * Rule Engine Execution Data Generator for a Dealer
     * 
     * @param \Akzo\Dealer $dealer Dealer for which to generate execution data
     * @param boolean $format none | json
     */
    public function toRuleEngineDealerExecData(\Akzo\Dealer $dealer, $executionDataType, $format = 'none') {
        $data = array();
    
        // Plug in scheme data
        $data['sid'] = $this->sid;
        $data['startDate'] = $this->startDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::RULE_ENGINE_FORMAT);
        $data['endDate'] = $this->endDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::RULE_ENGINE_FORMAT);
        $data['depot'] = $this->depot;
        $data['dealerAttribute'] = $this->dealerAttribute;

        // Plug in dealer data
        $data['dealer'] = $dealer->code;

        // Read in the execution data for the qualifying conditions
        $data['historicals'] = $this->_convertToRuleEngineExecData($this->historicals, $dealer, $executionDataType);
        $data['growths'] = $this->_convertToRuleEngineExecData($this->growths, $dealer, $executionDataType);
        $data['actuals'] = $this->_convertToRuleEngineExecData($this->actuals, $dealer, $executionDataType);
        $data['targets'] = $this->_convertToRuleEngineExecData($this->targets, $dealer, $executionDataType);
        $data['targetAchievements'] = $this->_convertToRuleEngineExecData($this->targetAchievements, $dealer, $executionDataType);
        $data['ratios'] = $this->_convertToRuleEngineExecData($this->ratios, $dealer, $executionDataType);

        // Read in the execution data for the templates
        $data['lapEntries'] = $this->_convertToRuleEngineExecData($this->lapEntries, $dealer, $executionDataType); // others
        $data['productEntries'] = $this->_convertToRuleEngineExecData($this->productEntries, $dealer, $executionDataType); //pri
        $data['inBillEntries'] = $this->_convertToRuleEngineExecData($this->inBillEntries, $dealer, $executionDataType); //inbill

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    private function _convertToRuleEngineExecData($attrs, \Akzo\Dealer $dealer, $executionDataType) {
        $data = array();
        foreach ($attrs as $idx=>$attr) {
            $data[] = $attr->toRuleEngineDealerExecData($dealer, $executionDataType, 'none');
        }
        return $data;
    }
}

