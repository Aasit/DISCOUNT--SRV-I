<?php
namespace Akzo\Scheme\Data\Template;

class SlabV3Template extends QCListTemplate implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Template DnI
     * @var \Akzo\Scheme\Data\Template\SlabV3\DnI
     */
    public $slabV3DnI;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = parent::toRuleEngineData();

        $data['slabV3DnI'] = $this->slabV3DnI->toRuleEngineData();

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
