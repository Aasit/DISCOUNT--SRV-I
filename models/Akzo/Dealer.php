<?php
namespace Akzo;

class Dealer extends \Native5\Product\Model\Model
{
    protected $table = 'ak_sales_dealers';
    protected $primaryKey = 'id';
    protected $appends = array('gid', 'name_code', 'credit_name_code');

    public function getNameCodeAttribute()
    {
        return $this->name." (".$this->code.")";
    }
    
    public function getCreditNameCodeAttribute()
    {
        return $this->credit_name." (".$this->credit_code.")";
    }

    public function getGidAttribute()
    {
        $pid = "C".$this->id;
        return $pid;
    }

    public function getAddressAttribute()
    {
        return $this->address_street . "," . $this->address_part2 . "," . $this->address_city . "-" . $this->address_postal_code;
    }

    public function depot()
    {
        return $this->belongsTo('\Akzo\Geography\Depot', 'depot_id', 'id');
    }

    public function salesData()
    {
        return $this->hasMany('\Akzo\Sales\Data', 'dealer_id', 'id');
    }

    public function salesTargets()
    {
        return $this->hasMany('\Akzo\Sales\Target', 'dealer_id', 'id');
    }

    public function salesOfficer()
    {
        return $this->belongsTo('\Akzo\Geography\Depot', 'depot_id', 'id');
    }
}

