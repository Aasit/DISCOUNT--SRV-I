<?php
namespace Akzo\Scheme\Data\Template;

class SlabTemplate extends QCListTemplate implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Template DnI
     * @var \Akzo\Scheme\Data\Template\Slab\DnI
     */
    public $slabDnI;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = parent::toRuleEngineData();

        $data['slabDnI'] = $this->slabDnI->toRuleEngineData();

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
