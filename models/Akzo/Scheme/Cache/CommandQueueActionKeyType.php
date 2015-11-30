<?php
namespace Akzo\Scheme\Cache;

class CommandQueueActionKeyType extends \MyCLabs\Enum\Enum {
    const STATUS = 'STATUS';
    const ACTION = 'ACTION';
    const ABORT_ACTION = 'ABORT_ACTION';
}