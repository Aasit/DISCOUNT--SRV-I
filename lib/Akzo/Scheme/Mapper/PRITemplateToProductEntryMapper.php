<?php
namespace Akzo\Scheme\Mapper;

class PRITemplateToProductEntryMapper implements \Akzo\Scheme\Mapper\Mapper
{
    public function map(array $templates) {
        // Initialize the productEntries array
        $productEntries = array();

        foreach ($templates as $idx=>$s) {
            // PHP Does not have type hinting for an array of objects, so need to check manually
            if (!$s instanceof \Akzo\Scheme\Data\Template\PRITemplate) {
                throw new \InvalidArgumentException(
                    'Source for map needs to be an instance of '.$this->getSourceType().'[]'
                );
            }

            // Collect qcList here from priPayouts and just plugin into every productEntry
            $qcList = array();
            foreach ($s->priDnI->priPayouts as $j=>$payout) {
                if (isset($payout->qcList) && !empty($payout->qcList)) {
                    $qcList = array_merge($qcList, $payout->qcList);
                }
            }

            foreach($s->priDnI->priProducts as $_idx=>$priProduct) {
                // Instantiate the destination class
                $destinationClass = '\\'.$this->getDestinationType();
                $d = new $destinationClass;

                // Perform straightforward mappings
                $d->tplId = $s->priDnI->id;
                $d->period = clone $s->priDnI->period;
                $d->product = clone $priProduct->product;
                $d->segment = $s->priDnI->segment;
                $d->projectSku = $s->priDnI->projectSku;
                $d->type = $s->priDnI->priType;

                // Add qcList to this productEntry once it has passed through the mapper
                $mapper = new \Akzo\Scheme\Mapper\DataQCToExecDataQCMapper();
                // Map without specifying a type, no need to breaks into historicals, growths, etc.
                $d->qcList = $mapper->map($qcList, null, $s->priDnI->segment);

                $productEntries[] = $d;
            }
        }

        return $productEntries;
    }

    public function getDestinationType() {
        return 'Akzo\Scheme\ExecData\ProductEntry';
    }

    public function getSourceType() {
        return 'Akzo\Scheme\Data\Template\PRITemplate';
    }
}
