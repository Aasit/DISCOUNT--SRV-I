<?php
namespace Akzo\Scheme\Data\Common;

class PayoutType extends \MyCLabs\Enum\Enum
{
    const RSPERLITRE = 'RSPERLITRE';
    const FLATPAYOUT = 'FLATPAYOUT';
    const GIFT = 'GIFT';
    const PERCENTAGE = 'PERCENTAGE';
}
