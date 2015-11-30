<?php
namespace Akzo\Scheme\Mapper;

class SlabV3TemplateToLapEntryMapper implements \Akzo\Scheme\Mapper\Mapper
{
    public function map(array $templates) {
        // Initialize the lapEntries array
        $lapEntries = array();

        foreach ($templates as $idx=>$s) {
            // PHP Does not have type hinting for an array of objects, so need to check manually
            if (!$s instanceof \Akzo\Scheme\Data\Template\SlabV3Template) {
                throw new \InvalidArgumentException(
                    'Source for map needs to be an instance of \Akzo\Scheme\Data\Template\SlabV3Template[]'
                );
            }

                // $GLOBALS['logger']->info("SLABV# template:   |||".$s);

            // Collect qcList here from lap[0] and just plugin into every lapEntry
            $qcList = array();
            foreach ($s->slabV3DnI->laps[0]->payouts as $j=>$payout) {
                if (isset($payout->qcList) && !empty($payout->qcList)) {
                    $qcList = array_merge($qcList, $payout->qcList);
                }
            }

            foreach ($s->slabV3DnI->laps as $_idx=>$lap) {
                // Instantiate the destination class
                $destinationClass = '\\'.$this->getDestinationType();
                $d = new $destinationClass;

                // Perform straightforward mappings
                $d->tplId = $s->slabV3DnI->id;
                $d->period = clone $lap->period;
                $d->packs = $s->slabV3DnI->packs;
                $d->projectSku = $s->slabV3DnI->projectSku;
                $d->segment = $s->slabV3DnI->segment;
                $d->type = clone $s->slabV3DnI->slabType;
                if (strcasecmp($d->type,\Akzo\Scheme\Data\Common\QuantityType::GROWTH) === 0) {
                    $d->previousPeriod = clone $lap->previousPeriod;
                    $d->currentPeriod = clone $lap->currentPeriod;
                }
                $d->products = $s->slabV3DnI->products;
                $d->payoutProducts = $s->slabV3DnI->payoutProducts;

                // Add qcList to this lapEntry once it has passed through the mapper
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                // Map without specifying a type, no need to break into historicals, growths, etc.
                // Pass the top level segment list to be used during execution
                $d->qcList = $mapper->map($qcList, null, $s->slabV3DnI->segment);

                $lapEntries[] = $d;
            }
        }

        return $lapEntries;
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData\LapEntry';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\Template\SlabV3Template[]';
    }
}
