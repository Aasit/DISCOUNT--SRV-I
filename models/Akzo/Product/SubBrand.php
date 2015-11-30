<?php
namespace Akzo\Product;

class SubBrand extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_sub_brands';
    protected $primaryKey = 'id';
    protected $appends = array('pid');

    public function getPidAttribute()
    {
        $pid = "S".$this->code;
        return $pid;
    }

    public function products()
    {
        return $this->hasMany('\Akzo\Product', 'subbrand_id', 'id');
    }

    public function cluster()
    {
        return $this->belongsTo('\Akzo\Product\Cluster', 'cluster_id', 'id');
    }

    public function groups()
    {
        return $this->hasMany('\Akzo\Product\Group', 'subbrand_id', 'id');
    }
}

