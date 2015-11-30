<?php
namespace Akzo\Scheme\Data\HeaderTemplate\Header;

class DealerAttribute implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Attribute Type
     * @var string
     */
    public $type;

    /**
     * Attribute name
     * @var string
     */
    public $attr;

    /**
     * Attibute Id
     * @var string
     */
    public $id;

    /**
     * Attribute excluded or not
     * @var boolean
     */
    public $excluded;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['type'] = $this->type;
        $data['attr'] = $this->attr;
        $data['id'] = $this->id;
        $data['excluded'] = $this->excluded;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

