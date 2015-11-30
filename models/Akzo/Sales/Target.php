<?php
namespace Akzo\Sales;

class Target extends \Native5\Product\Model\Model
{
    protected $table = 'ak_sales_targets';
    protected $primaryKey = 'id';

    public function dealer()
    {
        return $this->belongsTo('\Akzo\Dealer', 'dealer_id', 'id');
    }
}

