<?php
namespace Akzo\Scheme\Data\Template\PPI;

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
    public $ppiType;

    /**
     * DnI Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

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
     * Number of slabs
     * @var int
     */
    public $numSlabs;

    /**
     * Products for this template
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $products;

    /**
     * Product Pack Types for this template
     * @var array
     */
    public $packs;

    /**
     * Whether to include Project SKU or not for this template
     * @var boolean
     */
    public $projectSku;

    /**
     * Slab Payouts for this template
     * @var \Akzo\Scheme\Data\Template\PPI\Payout[]
     */
    public $slabPayouts;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['templateName'] = $this->templateName;
        $data['segment'] = $this->segment;
        $data['ppiType'] = $this->ppiType->getValue();
        $data['period'] = $this->period->toRuleEngineData();
        $data['numSlabs'] = $this->numSlabs;
        // Condense the products pid into a single product pid array
        $data['products'] = $this->_condenseProductsPid();
        $data['packs'] = $this->packs;
        $data['projectSku'] = $this->projectSku;

        $data['slabPayouts'] = array();
        foreach ($this->slabPayouts as $idx=>$payout) {
            $data['slabPayouts'][] = $payout->toRuleEngineData();
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

