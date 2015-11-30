<?php
namespace Akzo\Scheme;

class Data implements \Akzo\Scheme\Common\RuleEngineDataGeneratorInterface
{
    /**
     * Scheme Template Header
     * @var \Akzo\Scheme\Data\HeaderTemplate
     */
    public $schemeHeaderTemplate;

    /**
     * Scheme In-Bill Template Array
     * @var \Akzo\Scheme\Data\Template\InBillTemplate[]
     */
    public $inBillTplsRO = array();

    /**
     * Scheme PPI Template Array
     * @var \Akzo\Scheme\Data\Template\PPITemplate[]
     */
    public $ppiTpls = array();

    /**
     * Scheme PRI Template Array
     * @var \Akzo\Scheme\Data\Template\PRITemplate[]
     */
    public $priTpls = array();

    /**
     * Scheme Slab Template Array
     * @var \Akzo\Scheme\Data\Template\SlabTemplate[]
     */
    public $slabTpls = array();

    /**
     * Scheme Slab V2 Template Array
     * @var \Akzo\Scheme\Data\Template\SlabV2Template[]
     */
    public $slabV2Tpls = array();

    /**
     * Scheme Slab V3 Template Array
     * @var \Akzo\Scheme\Data\Template\SlabV3Template[]
     */
    public $slabV3Tpls = array();

    /**
     * Scheme Transition Comment (Optional)
     * @var string
     */
    public $comment;

    /**
     * Rule Engine Data Generator
     * @param $format none | json
     */
    public function toRuleEngineData($format = 'none') {
        $data = array();

        // Read in the scheme Header
        $data['schemeHeaderTemplate'] = $this->schemeHeaderTemplate->toRuleEngineData();

        // Read in the templates Data
        $data['inBillTplsRO'] = $this->_convertToRuleEngineData($this->inBillTplsRO);
        $data['ppiTpls'] = $this->_convertToRuleEngineData($this->ppiTpls);
        $data['priTpls'] = $this->_convertToRuleEngineData($this->priTpls);
        $data['slabTpls'] = $this->_convertToRuleEngineData($this->slabTpls);
        $data['slabV2Tpls'] = $this->_convertToRuleEngineData($this->slabV2Tpls);
        $data['slabV3Tpls'] = $this->_convertToRuleEngineData($this->slabV3Tpls);

        if (strcasecmp($format, 'json') === 0) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    private function _convertToRuleEngineData($attrs) {
        $data = array();
        foreach ($attrs as $idx=>$attr) {
            $data[] = $attr->toRuleEngineData();
        }
        return $data;
    }
}
