<?php
namespace Akzo\Scheme\Mapper;

interface Mapper {
    public function map(array $source);
    public function getDestinationType();
    public function getSourceType();
}
