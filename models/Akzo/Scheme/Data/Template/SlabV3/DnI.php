<?php
namespace Akzo\Scheme\Data\Template\SlabV3;

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
     * Quantity Type for this template
     * @var \Akzo\Scheme\Data\Common\QuantityType
     */
    public $slabType;

    /**
     * Products for this template
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $products;

    /**
     * Payout Products for this template
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $payoutProducts;

    /**
     * Product Pack Types for this template
     * @var array
     */
    public $packs;

    /**
     * Number of slabs
     * @var int
     */
    public $numSlabs;

    /**
     * Whether to include Project SKU or not for this template
     * @var boolean
     */
    public $projectSku;

    /**
     * Slab Payouts for this template
     * @var \Akzo\Scheme\Data\Template\Slab\Lap[]
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
        // Condense the products pid into a single product pid array
        $data['products'] = $this->_condenseProductsPid($this->products);
        $data['payoutProducts'] = $this->_condenseProductsPid($this->payoutProducts);
        $data['packs'] = $this->packs;
        $data['numSlabs'] = $this->numSlabs;
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

    private function _condenseProductsPid($products) {
        $data = array();
        $data[0] = array();
        $data[0]['pid'] = \Akzo\Scheme\Utils::condenseProductsPid($products);

        return $data;
    }
}

