<?php
namespace Akzo\Scheme\Data\Template\PRI;

class Product implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * The Product
     * @var \Akzo\Scheme\Data\Common\Product
     */
    public $product;
    /**
     * Product Minimum Value
     * @var float
     */
    public $value;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['product'] = $this->product->toRuleEngineData();
        $data['value'] = $this->value;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

