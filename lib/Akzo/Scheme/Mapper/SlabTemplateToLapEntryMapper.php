<?php
namespace Akzo\Scheme\Mapper;

class SlabTemplateToLapEntryMapper implements \Akzo\Scheme\Mapper\Mapper
{
    public function map(array $templates) {
        // Initialize the lapEntries array
        $lapEntries = array();

        foreach ($templates as $idx=>$s) {
            // PHP Does not have type hinting for an array of objects, so need to check manually
            if (!$s instanceof \Akzo\Scheme\Data\Template\SlabTemplate) {
                throw new \InvalidArgumentException(
                    'Source for map needs to be an instance of \Akzo\Scheme\Data\Template\SlabTemplate[]'
                );
            }

            // Collect qcList here from lap[0] and just plugin into every lapEntry
            $qcList = array();
            foreach ($s->slabDnI->laps[0]->payouts as $j=>$payout) {
                if (isset($payout->qcList) && !empty($payout->qcList)) {
                    $qcList = array_merge($qcList, $payout->qcList);
                }
            }

            foreach ($s->slabDnI->laps as $_idx=>$lap) {
                // Instantiate the destination class
                $destinationClass = '\\'.$this->getDestinationType();
                $d = new $destinationClass;

                // Perform straightforward mappings
                $d->tplId = $s->slabDnI->id;
                $d->period = clone $lap->period;
                $d->packs = $s->slabDnI->packs;
                $d->projectSku = $s->slabDnI->projectSku;
                $d->segment = $s->slabDnI->segment;
                $d->type = clone $s->slabDnI->slabType;
                if (strcasecmp($d->type,\Akzo\Scheme\Data\Common\QuantityType::GROWTH) === 0) {
                    $d->previousPeriod = clone $lap->previousPeriod;
                    $d->currentPeriod = clone $lap->currentPeriod;
                }
                $d->products = $s->slabDnI->products;

                // Add qcList to this lapEntry once it has passed through the mapper
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                // Map without specifying a type, no need to break into historicals, growths, etc.
                // Pass the top level segment list to be used during execution
                $d->qcList = $mapper->map($qcList, null, $s->slabDnI->segment);

                $lapEntries[] = $d;
            }
        }

        return $lapEntries;
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData\LapEntry';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\Template\SlabTemplate[]';
    }
}
