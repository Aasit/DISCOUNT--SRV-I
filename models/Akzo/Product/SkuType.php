<?php
namespace Akzo\Product;

class SkuType extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_sku_types';
    protected $primaryKey = 'id';

    public function products()
    {
        return $this->hasMany('\Akzo\Product');
    }
 
}

