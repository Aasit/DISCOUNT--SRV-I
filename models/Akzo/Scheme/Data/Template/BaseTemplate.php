<?php
namespace Akzo\Scheme\Data\Template;

class BaseTemplate implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Template Id
     * @var string
     */
    public $id;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        $data['id'] = $this->id;

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
