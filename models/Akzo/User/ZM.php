<?php
namespace Akzo\User;

class ZM extends \Native5\Product\Model\Model
{
    protected $table = 'ak_identity_zonal_managers';
    protected $primaryKey = 'id';
    protected $appends = array('type');

    public function user()
    {
        return $this->morphOne('\Akzo\User', 'identity');
    }

    public function getTypeAttribute()
    {
        return \Akzo\User\IdentityType::ZM;
    }

    public function zone()
    {
        return $this->belongsTo('\Akzo\Geography\Zone', 'zone_id', 'id');
    }

    public function scheme_reviewer()
    {
        return $this->belongsTo('\Akzo\User\RM', 'scheme_reviewer_id', 'id');
    }

    public function scheme_approver()
    {
        return $this->belongsTo('\Akzo\User\RM', 'scheme_approver_id', 'id');
    }

    public function scheme_payout_approver()
    {
        return $this->belongsTo('\Akzo\User\RM', 'scheme_payout_approver_id', 'id');
    }

}
