<?php
namespace Akzo\Scheme\Data\Template\SlabV2;

class Lap implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Lap Id
     * @var string
     */
    public $id;

    /**
     * Lap Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

    /**
     * Lap Payouts for each set of product rows
     * @var \Akzo\Scheme\Data\Template\SlabV2\Payout[]
     */
    public $payouts;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['period'] = $this->period->toRuleEngineData();
        $data['payouts'] = array();
        foreach ($this->payouts as $idx=>$payout) {
            $data['payouts'][] = $payout->toRuleEngineData();
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

