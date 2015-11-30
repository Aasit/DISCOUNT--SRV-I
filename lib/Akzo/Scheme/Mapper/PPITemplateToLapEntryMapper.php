<?php
namespace Akzo\Scheme\Mapper;

class PPITemplateToLapEntryMapper implements \Akzo\Scheme\Mapper\Mapper
{
    public function map(array $templates) {
        // Initialize the lapEntries array
        $lapEntries = array();

        foreach ($templates as $idx=>$s) {
            // PHP Does not have type hinting for an array of objects, so need to check manually
            if (!$s instanceof \Akzo\Scheme\Data\Template\PPITemplate) {
                throw new \InvalidArgumentException(
                    'Source for map needs to be an instance of \Akzo\Scheme\Data\Template\PPITemplate[]'
                );
            }

            // Instantiate the destination class
            $destinationClass = '\\'.$this->getDestinationType();
            $d = new $destinationClass;

            // Perform straightforward mappings
            $d->tplId = $s->ppiDnI->id;
            $d->period = clone $s->ppiDnI->period;
            $d->packs = $s->ppiDnI->packs;
            $d->projectSku = $s->ppiDnI->projectSku;
            $d->segment = $s->ppiDnI->segment;
            $d->type = $s->ppiDnI->ppiType;
            if (strcasecmp($d->type,\Akzo\Scheme\Data\Common\QuantityType::GROWTH) === 0) {
                $d->previousPeriod = clone $s->ppiDnI->previousPeriod;
                $d->currentPeriod = clone $s->ppiDnI->currentPeriod;
            }
            $d->products = $s->ppiDnI->products;

            // Collect the qcs & map to execution qcList
            $qcList = array();
            foreach ($s->ppiDnI->slabPayouts as $_idx=>$payout) {
                if (isset($payout->qcList) && !empty($payout->qcList)) {
                    $qcList = array_merge($qcList, $payout->qcList);
                }
            }
            $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
            // Map without specifying a type, no need to break into historicals, growths, etc.
            $d->qcList = $mapper->map($qcList, null, $s->ppiDnI->segment);

            $lapEntries[] = $d;
        }

        return $lapEntries;
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData\LapEntry';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\Template\PPITemplate[]';
    }
}
