<?php
namespace Akzo\Scheme\Mapper;

class DataToExecDataMap extends \BCC\AutoMapperBundle\Mapper\AbstractMap
{
    private static $_SCHEME_QCS;
    private static $_SCHEME_QCS_COLLECTED = false;

    function __construct() {
        $this->buildDefaultMap();
        $this->setOverwriteIfSet(false);

        // Map Execution Header
        $this->route('sid', 'schemeHeaderTemplate.id');
        $this->route('startDate', 'schemeHeaderTemplate.schemeHeader.startDate');
        $this->route('endDate', 'schemeHeaderTemplate.schemeHeader.endDate');

        // Set QC Maps
        $this->_setHistoricalQCMap();
        $this->_setGrowthQCMap();
        $this->_setActualQCMap();
        $this->_setTargetQCMap();
        $this->_setTargetAchievementQCMap();
        $this->_setRatioQCMap();

        // Set Template Entries
        $this->_setLapEntriesMap();
        $this->_setProductEntriesMap();
        $this->_setInBillEntriesMap();
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data';
    }

    public static function collectSchemeQCs(\Akzo\Scheme\Data $s) {
        // Check if collected flag is set
        if (self::$_SCHEME_QCS_COLLECTED) {
            return self::$_SCHEME_QCS;
        }

        // Merge QCs from the header and templates
        self::$_SCHEME_QCS = array_merge(
            $s->schemeHeaderTemplate->qcList,
            self::_collectTemplateQCs($s->ppiTpls),
            self::_collectTemplateQCs($s->priTpls),
            self::_collectTemplateQCs($s->slabTpls),
            self::_collectTemplateQCs($s->slabV3Tpls),
            self::_collectTemplateQCs($s->slabV2Tpls)
        );

        // Set collected flag to true
        self::$_SCHEME_QCS_COLLECTED = true;

        return self::$_SCHEME_QCS;
    }

    // ****** Private Functions to set QCs ****** //

    private function _setHistoricalQCMap() {
        $this->forMember('historicals', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                // Map scheme QCs to execute QCs
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                return $mapper->map(
                    \Akzo\Scheme\Mapper\DataToExecDataMap::collectSchemeQCs($s),
                    \Akzo\Scheme\Data\QualifyingCondition\Type::HISTORICAL
                );
            }
        ));
    }

    private function _setGrowthQCMap() {
        $this->forMember('growths', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                // Map scheme QCs to execute QCs
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                return $mapper->map(
                    \Akzo\Scheme\Mapper\DataToExecDataMap::collectSchemeQCs($s),
                    \Akzo\Scheme\Data\QualifyingCondition\Type::GROWTH
                );
            }
        ));
    }

    private function _setActualQCMap() {
        $this->forMember('actuals', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                // Map scheme QCs to execute QCs
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                return $mapper->map(
                    \Akzo\Scheme\Mapper\DataToExecDataMap::collectSchemeQCs($s),
                    \Akzo\Scheme\Data\QualifyingCondition\Type::ACTUAL
                );
            }
        ));
    }

    private function _setTargetQCMap() {
        $this->forMember('targets', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                // Map scheme QCs to execute QCs
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                return $mapper->map(
                    \Akzo\Scheme\Mapper\DataToExecDataMap::collectSchemeQCs($s),
                    \Akzo\Scheme\Data\QualifyingCondition\Type::TARGET
                );
            }
        ));
    }

    private function _setTargetAchievementQCMap() {
        $this->forMember('targetAchievements', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                // Map scheme QCs to execute QCs
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                return $mapper->map(
                    \Akzo\Scheme\Mapper\DataToExecDataMap::collectSchemeQCs($s),
                    \Akzo\Scheme\Data\QualifyingCondition\Type::TARGET_ACHIEVEMENT
                );
            }
        ));
    }

    private function _setRatioQCMap() {
        $this->forMember('ratios', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                // Map scheme QCs to execute QCs
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                return $mapper->map(
                    \Akzo\Scheme\Mapper\DataToExecDataMap::collectSchemeQCs($s),
                    \Akzo\Scheme\Data\QualifyingCondition\Type::RATIO
                );
            }
        ));
    }

    // ****** Private Functions to set Template Data ****** //
    private function _setLapEntriesMap() {
        $this->forMember('lapEntries', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                $lapEntries = array();

                // Map the PPI Templates into Lap Entries and merge
                $mapper = new \Akzo\Scheme\Mapper\PPITemplateToLapEntryMapper();
                $lapEntries = array_merge($lapEntries, $mapper->map($s->ppiTpls));

                // Map the Slab Templates into Lap Entries and merge
                $mapper = new \Akzo\Scheme\Mapper\SlabTemplateToLapEntryMapper();
                $lapEntries = array_merge($lapEntries, $mapper->map($s->slabTpls));

                // Map the Slab V3 Templates into Lap Entries and merge
                $mapper = new \Akzo\Scheme\Mapper\SlabV3TemplateToLapEntryMapper();
                $lapEntries = array_merge($lapEntries, $mapper->map($s->slabV3Tpls));

                // Map the new Slab Templates into Lap Entries and merge
                $mapper = new \Akzo\Scheme\Mapper\NewSlabTemplateToLapEntryMapper();
                $lapEntries = array_merge($lapEntries, $mapper->map($s->slabV2Tpls));
            
                return $lapEntries;
            }
        ));
    }

    private function _setProductEntriesMap() {
        $this->forMember('productEntries', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                $productEntries = array();

                // Map the PRI Templates into Product Entries and merge
                $mapper = new \Akzo\Scheme\Mapper\PRITemplateToProductEntryMapper();
                $productEntries = array_merge($productEntries, $mapper->map($s->priTpls));

                return $productEntries;
            }
        ));
    }

    private function _setInBillEntriesMap() {
        $this->forMember('inBillEntries', new \BCC\AutoMapperBundle\Mapper\FieldAccessor\Closure(
            function(\Akzo\Scheme\Data $s) {
                $inBillEntries = array();

                // Map the PRI Templates into Product Entries and merge
                $mapper = new \Akzo\Scheme\Mapper\InBillTemplateToInBillEntryMapper();
                $inBillEntries = array_merge($inBillEntries, $mapper->map($s->inBillTplsRO));

                return $inBillEntries;
            }
        ));
    }

    // ****** Private Helper Functions ******//

    private static function _collectTemplateQCs(array $templates) {
        $qcList = array();
        foreach ($templates as $idx=>$template) {
            $qcList = array_merge(
                $qcList,
                (isset($template->qcList) && !empty($template->qcList)) ? $template->qcList : array()
            );
        }

        return $qcList;
    }
}
