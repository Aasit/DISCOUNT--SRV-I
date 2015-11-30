<?php
namespace Akzo;

class Product extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_skus';
    protected $primaryKey = 'id';
    //protected $appends = array('pid');

    public function getPidAttribute()
    {
        $pid = "P".$this->code;
        return $pid;
    }

    public function brand()
    {
        return $this->belongsTo('\Akzo\Product\Brand', 'brand_id', 'id');
    }

    public function cluster()
    {
        return $this->belongsTo('\Akzo\Product\Cluster', 'cluster_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo('\Akzo\Product\Group', 'group_id', 'id');
    }

    public function packType()
    {
        return $this->belongsTo('\Akzo\Product\PackType', 'pack_type_id', 'id');
    }

    public function skuType()
    {
        return $this->belongsTo('\Akzo\Product\SkuType', 'sku_type_id', 'id');
    }

    public function subBrand()
    {
        return $this->belongsTo('\Akzo\Product\SubBrand', 'subbrand_id', 'id');
    }
 
}

