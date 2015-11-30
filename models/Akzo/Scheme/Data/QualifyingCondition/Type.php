<?php
namespace Akzo\Scheme\Data\QualifyingCondition;

class Type extends \MyCLabs\Enum\Enum
{
    const HISTORICAL = "HISTORICAL";
    const GROWTH = "GROWTH";
    const ACTUAL = "ACTUAL";
    const TARGET = "TARGET";
    const TARGET_ACHIEVEMENT = "TARGET_ACHIEVEMENT";
    const RATIO = "RATIO";
}

