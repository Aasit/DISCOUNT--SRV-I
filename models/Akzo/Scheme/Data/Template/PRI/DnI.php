<?php
namespace Akzo\Scheme\Data\Template\PRI;

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
    public $priType;

    /**
     * Products for this template
     * @var \Akzo\Scheme\Data\Template\PRI\Product[]
     */
    public $priProducts;

    /**
     * DnI Period
     * @var \Akzo\Scheme\Data\Common\Period
     */
    public $period;

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
     * @var \Akzo\Scheme\Data\Template\PRI\Payout[]
     */
    public $priPayouts;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        $data['templateName'] = $this->templateName;
        $data['segment'] = $this->segment;
        $data['priType'] = $this->priType->getValue();
        $data['priProducts'] = array();
        foreach ($this->priProducts as $idx=>$product) {
            $data['priProducts'][] = $product->toRuleEngineData();
        }
        $data['period'] = $this->period->toRuleEngineData();
        $data['numSlabs'] = $this->numSlabs;
        $data['projectSku'] = $this->projectSku;

        $data['priPayouts'] = array();
        foreach ($this->priPayouts as $idx=>$payout) {
            $data['priPayouts'][] = $payout->toRuleEngineData();
        }

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

