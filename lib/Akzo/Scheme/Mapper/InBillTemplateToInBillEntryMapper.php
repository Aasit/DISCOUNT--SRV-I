<?php
namespace Akzo\Scheme\Mapper;

class InBillTemplateToInBillEntryMapper implements \Akzo\Scheme\Mapper\Mapper
{
    /*
     *    InBill Template To InBill Entry Mapping
     *    ---------------------------------------
     *
     *    inBillEntries[n]->tplId <=== inBillTpls[i]->id
     *    inBillEntries[n]->period <=== inBillTpls[i]->inBillDnI->inBillLaps[p]->period
     *    inBillEntries[n]->product <=== inBillTpls[i]->inBillDnI->inBillLaps[p]->payouts[q]->products
     *    inBillEntries[n]->packs <=== inBillTpls[i]->inBillDnI->inBillLaps[p]->payouts[q]->packs
     */
    public function map(array $templates) {
        // Initialize the inBillEntries array
        $inBillEntries = array();

        foreach ($templates as $idx=>$s) {
            // PHP Does not have type hinting for an array of objects, so need to check manually
            if (!$s instanceof \Akzo\Scheme\Data\Template\InBillTemplate) {
                throw new \InvalidArgumentException(
                    'Source for map needs to be an instance of '.$this->getSourceType().'[]'
                );
            }

            // Iterate through the laps to get the period
            foreach ($s->inBillDnI->inBillLaps as $_idx=>$lap) {
                // Iterate through the lap payouts to get the products
                foreach ($lap->payouts as $__idx=>$payout) {
                    // Instantiate the destination class
                    $destinationClass = '\\'.$this->getDestinationType();
                    $d = new $destinationClass;

                    // Perform straightforward mappings
                    $d->tplId = $s->inBillDnI->id;
                    $d->period = clone $lap->period;
                    $d->product = $payout->products;
                    $d->packs = $payout->packs;
                    $d->projectSku = $s->inBillDnI->projectSku;
                    $d->segment = $s->inBillDnI->segment;

                    $inBillEntries[] = $d;
                }
            }
        }

        return $inBillEntries;
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData\InBillEntry';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\Template\InBillTemplate';
    }
}
