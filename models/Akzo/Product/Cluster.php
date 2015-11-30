<?php
namespace Akzo\Product;

class Cluster extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_clusters';
    protected $primaryKey = 'id';
    protected $appends = array('pid');

    public function getPidAttribute()
    {
        $pid = "C".$this->code;
        return $pid;
    }

    public function products()
    {
        return $this->hasMany('\Akzo\Product', 'cluster_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('\Akzo\Product\Brand', 'brand_id', 'id');
    }

    public function subbrands()
    {
        return $this->hasMany('\Akzo\Product\SubBrand', 'cluster_id', 'id');
    }
 
}

