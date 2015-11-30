<?php
namespace Akzo\Scheme\Data\Template;

class SlabV2Template extends QCListTemplate implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Template DnI
     * @var \Akzo\Scheme\Data\Template\SlabV2\DnI
     */
    public $slabV2DnI;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = parent::toRuleEngineData();

        $data['slabV2DnI'] = $this->slabV2DnI->toRuleEngineData();

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}
