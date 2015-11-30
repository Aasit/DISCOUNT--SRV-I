<?php
namespace Akzo\Scheme\ResultData;

class Entry
{
    /**
     * Scheme Id
     * @var string
     */
    public $sid;

    /**
     * Rule Id
     * @var string
     */
    public $ruleId;

    /**
     * Template Id assciated to this payout
     * @var string
     */
    public $tplId;

    /**
     * Period for this payout
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

    /**
     * Payout Condition Percentage Applicable to this entry (only for QC rule groups)
     * @var float
     */
    public $payoutConditionApplicable;

    /**
     * Payout amount for this entry
     * @var float
     */
    public $dniPayout;

    /**
     * Rule Group
     * @param string Rule Group
     */
    public function setRuleGroup($ruleGroup) {
        if ($this->_contains($ruleGroup, 'INBILL')) {
            // In Bill Templates do not have QC
            $this->ruleGroup = \Akzo\Scheme\ResultData\GroupType::WITHOUT_QC;
        } else {
            if ($this->_endsWith($ruleGroup, 'NO_QC')) {
                $this->ruleGroup = \Akzo\Scheme\ResultData\GroupType::WITHOUT_QC;
            } else {
                $this->ruleGroup = \Akzo\Scheme\ResultData\GroupType::WITH_QC;
            }
        }
    }

    private function _contains($string, $test) {
        return preg_match('/'.$test.'/', $string);
    }

    private function _endsWith($string, $test) {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) return false;
        return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
    }
}
