<?php
namespace Akzo\Scheme\Data\Common;

class Product implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Product Id
     * @var string
     */
    public $pid;

    /**
     * Product name
     * @var string
     */
    public $name;

    /**
     * Product excluded or not
     * @var boolean
     */
    public $excluded;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();
        $data['pid'] = $this->pid;
        $data['name'] = $this->name;
        $data['excluded'] = $this->excluded;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

