<?php
namespace Akzo\Scheme\Data\Template\InBill;

class Payout implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Payout Id
     * @var string
     */
    public $id;

    /**
     * Payout Products for this row
     * @var \Akzo\Scheme\Data\Common\Product[]
     */
    public $products;

    /**
     * Payout Type for this row
     * @var \Akzo\Scheme\Data\Common\PayoutType
     */
    public $payoutType;

    /**
     * Payout Id
     * @var float
     */
    public $lapRate;

    /**
     * Product Pack Types for this row
     * @var array
     */
    public $packs;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;
        //$data['products'] = array();
        //foreach ($this->products as $idx=>$product) {
            //$data['products'][] = $product->toRuleEngineData();
        //}
        // Condense the products pid into a single product pid array
        $data['products'] = $this->_condenseProductsPid();
        $data['payoutType'] = $this->payoutType->getValue();
        $data['lapRate'] = $this->lapRate;
        $data['packs'] = $this->packs;

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

