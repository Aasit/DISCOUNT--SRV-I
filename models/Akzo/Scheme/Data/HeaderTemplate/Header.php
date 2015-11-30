<?php
namespace Akzo\Scheme\Data\HeaderTemplate;

class Header implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Scheme Id
     * @var string
     */
    public $id;

    /**
     * Scheme Name
     * @var string
     */
    public $name;

    /**
     * Scheme Type
     * @var \Akzo\Scheme\Data\HeaderTemplate\Header\SchemeType
     */
    public $type;

    /**
     * Scheme Sales Segments Applicable
     * @var array
     */
    public $segment;

    /**
     * Scheme Associated Dealer Attributes
     * @var \Akzo\Scheme\Data\HeaderTemplate\Header\DealerAttribute[]
     */
    public $dealerAttributes;

    /**
     * Scheme Associated Sales Geographies
     * @var \Akzo\Scheme\Data\HeaderTemplate\Header\SalesGeography[]
     */
    public $salesGeography;

    /**
     * Scheme Terms and Conditions
     * @var string
     */
    public $terms;

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

        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['type'] = $this->type->getValue();
        $data['segment'] = $this->segment;
        $data['startDate'] = $this->startDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::RULE_ENGINE_FORMAT);
        $data['endDate'] = $this->endDate->format(\Akzo\Scheme\Data\Common\DateTimeFormat::RULE_ENGINE_FORMAT);

        $data['dealerAttributes'] = array();
        foreach ($this->dealerAttributes as $idx=>$attr) {
            $data['dealerAttributes'][] = $attr->toRuleEngineData();
        }

        $data['salesGeography'] = array();
        foreach ($this->salesGeography as $idx=>$salesGeo) {
            $data['salesGeography'][] = $salesGeo->toRuleEngineData();
        }

        $data['terms'] = $this->terms;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
