<?php
namespace Akzo\Geography;

class Region extends \Native5\Product\Model\Model
{
    protected $table = 'ak_sales_regions';
    protected $primaryKey = 'id';
    protected $appends = array('gid');

    public function getGidAttribute()
    {
        $pid = "R".$this->id;
        return $pid;
    }

    public function zones()
    {
        return $this->hasMany('\Akzo\Geography\Zone', 'region_id', 'id');
    }

    public function depots()
    {
        return $this->hasManyThrough('\Akzo\Geography\Depot', '\Akzo\Geography\Zone', 'region_id', 'zone_id');
    }
}

