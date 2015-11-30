<?php
namespace Akzo\Product;

class Group extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_groups';
    protected $primaryKey = 'id';
    protected $appends = array('pid');

    public function getPidAttribute()
    {
        $pid = "G".$this->code;
        return $pid;
    }
    public function products()
    {
        return $this->hasMany('\Akzo\Product', 'group_id', 'id');
    }

    public function subBrand()
    {
        return $this->belongsTo('\Akzo\Product\SubBrand', 'subbrand_id', 'id');
    }
 
}

