<?php
namespace Akzo\Scheme\Data\Template\SlabV2;

class DnI implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * DnI Id
     * @var string
     */
    public $id;

    /**
     * Template Name
     * @var string
     */
    public $templateName;

    /**
     * Template Segments Applicable
     * @var array
     */
    public $segment;

    /**
     * Quantity Type for this template
     * @var \Akzo\Scheme\Data\Common\QuantityType
     */
    public $slabType;

    /**
     * DnI Period
     * @var \Akzo\Scheme\Data\Common\PreviousPeriod
     */
    public $previousPeriod;

    /**
     * DnI Period
     * @var \Akzo\Scheme\Data\Common\CurrentPeriod
     */
    public $currentPeriod;

    /**
     * Number of laps
     * @var int
     */
    public $numLaps;

    /**
     * Whether to include Project SKU or not for this template
     * @var boolean
     */
    public $projectSku;

    /**
     * Slab Payouts for this template
     * @var \Akzo\Scheme\Data\Template\SlabV2\Lap[]
     */
    public $laps;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['templateName'] = $this->templateName;
        $data['segment'] = $this->segment;
        $data['slabType'] = $this->slabType->getValue();
        $data['numLaps'] = $this->numLaps;
        $data['projectSku'] = $this->projectSku;
        $data['laps'] = array();
        foreach ($this->laps as $idx=>$lap) {
            $data['laps'][] = $lap->toRuleEngineData();
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

