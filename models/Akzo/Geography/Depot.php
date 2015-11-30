<?php
namespace Akzo\Geography;

class Depot extends \Native5\Product\Model\Model
{
    const TABLE_NAME = 'ak_sales_depots';
    protected $table = self::TABLE_NAME;
    protected $primaryKey = 'id';
    protected $appends = array('depot_name', 'gid');

    public function getGidAttribute()
    {
        $pid = "D".$this->id;
        return $pid;
    }

    public function getDepotNameAttribute()
    {
        $nameArray = preg_split('/[-]/', $this->name);
        return trim($nameArray[1]);
    }

    public function zone()
    {
        return $this->belongsTo('\Akzo\Geography\Zone', 'zone_id', 'id');
    }

    public function dealers()
    {
        return $this->hasMany('\Akzo\Dealer');
    }

}
