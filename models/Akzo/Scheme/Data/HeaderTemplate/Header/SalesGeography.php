<?php
namespace Akzo\Scheme\Data\HeaderTemplate\Header;

class SalesGeography implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Geography Id
     * @var string
     */
    public $gid;

    /**
     * Geography name
     * @var string
     */
    public $name;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['gid'] = $this->gid;
        $data['name'] = $this->name;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}

