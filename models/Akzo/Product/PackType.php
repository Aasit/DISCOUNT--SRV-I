<?php
namespace Akzo\Product;

class PackType extends \Native5\Product\Model\Model
{
    protected $table = 'ak_product_pack_types';
    protected $primaryKey = 'id';

    public function products()
    {
        return $this->hasMany('\Akzo\Product');
    }
 
}

