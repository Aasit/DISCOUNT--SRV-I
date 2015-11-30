<?php
namespace Akzo\User;

class RM extends \Native5\Product\Model\Model
{
    protected $table = 'ak_identity_regional_managers';
    protected $primaryKey = 'id';
    protected $appends = array('type');

    public function getTypeAttribute()
    {
        return \Akzo\User\IdentityType::RM;
    }

    public function user()
    {
        return $this->morphOne('\Akzo\User', 'identity');
    }

    public function region()
    {
        return $this->belongsTo('\Akzo\Geography\Region', 'region_id', 'id');
    }
}
