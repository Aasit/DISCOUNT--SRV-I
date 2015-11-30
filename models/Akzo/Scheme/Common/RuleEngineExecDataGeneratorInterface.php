<?php
namespace Akzo\Scheme\Common;

interface RuleEngineExecDataGeneratorInterface {
    public function toRuleEngineDealerExecData(\Akzo\Dealer $dealer, $executionDataType, $format);
}
