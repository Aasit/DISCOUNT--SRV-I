<?php
namespace Akzo\Product;

class Brand extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_brands';
    protected $primaryKey = 'id';
    protected $appends = array('pid');

    public function getPidAttribute()
    {
        $pid = "B".$this->code;
        return $pid;
    }

    public function products()
    {
        return $this->hasMany('\Akzo\Product', 'brand_id', 'id');
    }

    public function clusters()
    {
        return $this->hasMany('\Akzo\Product\Cluster', 'brand_id', 'id');
    }
}

