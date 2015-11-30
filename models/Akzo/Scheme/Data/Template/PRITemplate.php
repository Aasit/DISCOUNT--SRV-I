<?php
namespace Akzo\Scheme\Data\Template;

class PRITemplate extends QCListTemplate implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Template DnI
     * @var \Akzo\Scheme\Data\Template\PRI\DnI
     */
    public $priDnI;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = parent::toRuleEngineData();

        $data['priDnI'] = $this->priDnI->toRuleEngineData();

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
