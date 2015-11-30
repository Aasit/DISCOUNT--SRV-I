<?php
namespace Akzo\Scheme\Mapper;

class DataQCToExecDataQCMapper implements \Akzo\Scheme\Mapper\Mapper
{
    public function map(array $qcList, $filterQcType = null) {
        // Initialize the QcList
        $marshalledQcList = array();

        foreach ($qcList as $idx=>$_qc) {
            if (!empty($filterQcType) && strcasecmp($_qc->name->getValue(), $filterQcType) !== 0) {
                continue;
            }

            // Clone the existing qc into a new one and operate on that
            $qc = clone $_qc;
            // Plugin the segment
            // $qc->segment = $segment;

            $marshalledQcList[] = $qc;
        }

        return $marshalledQcList;
    }

    public function getDestinationType() {
        return 'array';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\QualifyingCondition\BaseQC';
    }
}
