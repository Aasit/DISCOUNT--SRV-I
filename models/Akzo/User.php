<?php
namespace Akzo;

class User extends \Native5\Product\Model\Model
{
    protected $table = 'ak_users';
    protected $primaryKey = 'id';
    protected $hidden = array(
        'id',
        'subject'
    );
    protected $appends = array('name');

    // Extra variables
    protected $_subject;

    public function identity()
    {
        return $this->morphTo();
    }

    public function initiatedSchemes()
    {
        return $this->hasMany('\Akzo\Scheme', 'initiator_id', 'id');
    }

    public function toBeReviewedSchemes()
    {
        return $this->hasMany('\Akzo\Scheme', 'reviewer_id', 'id');
    }

    public function toBeApprovedSchemes()
    {
        return $this->hasMany('\Akzo\Scheme', 'approver_id', 'id');
    }

    public function toBePayoutApprovedSchemes()
    {
        return $this->hasMany('\Akzo\Scheme', 'payout_approver_id', 'id');
    }

    public function cards()
    {
        return $this->hasMany('\Native5\Ui\Card', 'user_id', 'id');
    }

    public function schemeTransitions()
    {
        return $this->hasMany('\Akzo\Scheme\Transition', 'user_id', 'id');
    }

    public function getTypeAttribute()
    {
        return $this->identity->type;
    }

    public function getNameAttribute()
    {
        return $this->identity->name;
    }

    // Methods to set/get subject
    public function getSubjectAttribute()
    {
        if (isset($this->_subject)) {
            return $this->_subject;
        }

        return null;
    }

    // Methods to set/get subject
    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }
}

