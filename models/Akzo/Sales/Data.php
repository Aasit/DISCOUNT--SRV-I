<?php
namespace Akzo\Sales;

class Data extends \Native5\Product\Model\Model
{
    protected $table = 'ak_sales_data';
    protected $primaryKey = 'id';

    public function dealer()
    {
        return $this->belongsTo('\Akzo\Dealer', 'dealer_id', 'id');
    }

}

