<?php
namespace Akzo\Scheme\Data\Template\InBill;

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
     * Lap objects for this template
     * @var \Akzo\Scheme\Data\Template\InBill\Lap[]
     */
    public $inBillLaps;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['templateName'] = $this->templateName;
        $data['segment'] = $this->segment;
        $data['numLaps'] = $this->numLaps;
        $data['projectSku'] = $this->projectSku;

        $data['inBillLaps'] = array();
        foreach ($this->inBillLaps as $idx=>$lap) {
            $data['inBillLaps'][] = $lap->toRuleEngineData();
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

