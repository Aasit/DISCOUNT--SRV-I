<?php
namespace Akzo\Geography;

class Zone extends \Native5\Product\Model\Model
{
    const TABLE_NAME = 'ak_sales_zones';
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $appends = array('gid');

    public function getGidAttribute()
    {
        $pid = "Z".$this->id;
        return $pid;
    }

    public function depots()
    {
        return $this->hasMany('\Akzo\Geography\Depot', 'zone_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('\Akzo\Geography\Region', 'region_id', 'id');
    }

    public function dealers()
    {
        return $this->hasManyThrough('\Akzo\Dealer', '\Akzo\Geography\Depot', 'zone_id', 'depot_id');
    }
}

