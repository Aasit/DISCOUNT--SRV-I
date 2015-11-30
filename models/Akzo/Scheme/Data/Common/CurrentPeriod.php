<?php
namespace Akzo\Scheme\Data\Common;

class CurrentPeriod implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Period End Date
     * @param string
     */
    public function setStartDate($startDate) {
        $this->startDate = \DateTime::createFromFormat(\Akzo\Scheme\Data\Common\DateTimeFormat::INCOMING_FORMAT, $startDate);
    }

    /**
     * Period End Date
     * @param string
     */
    public function setEndDate($endDate) {
        $this->endDate = \DateTime::createFromFormat(\Akzo\Scheme\Data\Common\DateTimeFormat::INCOMING_FORMAT, $endDate);
    }

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();
        $data['startDate'] = $this->startDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::RULE_ENGINE_FORMAT);
        $data['endDate'] = $this->endDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::RULE_ENGINE_FORMAT);

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

