<?php
namespace Akzo\Scheme\Mapper;

class NewSlabTemplateToLapEntryMapper implements \Akzo\Scheme\Mapper\Mapper
{
    public function map(array $templates) {
        // Initialize the lapEntries array
        $lapEntries = array();

        foreach ($templates as $idx=>$s) {
            // PHP Does not have type hinting for an array of objects, so need to check manually
            if (!$s instanceof \Akzo\Scheme\Data\Template\SlabV2Template) {
                throw new \InvalidArgumentException(
                    'Source for map needs to be an instance of \Akzo\Scheme\Data\Template\SlabV2Template[]'
                );
            }

            // Collect qcList here from lap[0] and just plugin into every lapEntry
            $qcList = array();
            foreach ($s->slabV2DnI->laps[0]->payouts as $j=>$payout) {
                if (isset($payout->qcList) && !empty($payout->qcList)) {
                    $qcList = array_merge($qcList, $payout->qcList);
                }
            }

            foreach ($s->slabV2DnI->laps as $_idx=>$lap) {
                // Instantiate the destination class

                // Iterate through the lap payouts to get the products
                foreach ($lap->payouts as $__idx=>$payout) {
                    // Instantiate the destination class
                    $destinationClass = '\\'.$this->getDestinationType();
                    $d = new $destinationClass;

                    // Perform straightforward mappings
                    $d->tplId = $s->slabV2DnI->id;
                    $d->period = clone $lap->period;
                    $d->segment = $s->slabV2DnI->segment;
                    $d->type = clone $s->slabV2DnI->slabType;
                    if (strcasecmp($d->type,\Akzo\Scheme\Data\Common\QuantityType::GROWTH) === 0) {
                        $d->previousPeriod = clone $lap->previousPeriod;
                        $d->currentPeriod = clone $lap->currentPeriod;
                    }
                    $d->products = $payout->products;
                    $d->packs = $payout->packs;
                    $d->projectSku = $s->slabV2DnI->projectSku;
                    $lapEntries[] = $d;

                    // Add qcList to this lapEntry once it has passed through the mapper
                    $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                    $d->qcList = $mapper->map($qcList, null, $s->slabV2DnI->segment);
                }
                
            }
        }

        return $lapEntries;
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData\LapEntry';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\Template\SlabV2Template[]';
    }
}
