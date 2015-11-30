<?php
namespace Akzo\Scheme;

class ResultData
{
    /**
     * Output for InBill Templates
     * @var \Akzo\Scheme\ResultData\Entry[]
     */
    public $inBills;

    /**
     * Output for PPI Templates
     * @var \Akzo\Scheme\ResultData\Entry[]
     */
    public $ppiOutputs;

    /**
     * Output for PRI Templates
     * @var \Akzo\Scheme\ResultData\Entry[]
     */
    public $priOutputs;

    /**
     * Output for Slab Templates
     * @var \Akzo\Scheme\ResultData\Entry[]
     */
    public $slabOutputs;

    /**
     * Output for Slab V2 Templates
     * @var \Akzo\Scheme\ResultData\Entry[]
     */
    public $slabV2Outputs;
}
