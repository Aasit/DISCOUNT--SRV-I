<?php
namespace Akzo;

class Scheme extends \Native5\Product\Model\Model
    implements \Finite\StatefulInterface
{
    protected $table = 'ak_discounts_scheme_details';
    protected $primaryKey = 'id';
    protected $hidden = array(
        'id'
    );
    protected $appends = array('is_editable');

    // Custom variable comment
    private $_comment;

    public function initiator()
    {
        return $this->belongsTo('\Akzo\User', 'initiator_id', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo('\Akzo\User', 'reviewer_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo('\Akzo\User', 'approver_id', 'id');
    }

    public function payout_approver()
    {
        return $this->belongsTo('\Akzo\User', 'payout_approver_id', 'id');
    }

    public function transitions()
    {
        return $this->hasMany('\Akzo\Scheme\Transition', 'scheme_id', 'id');
    }

    // ****** Implemented for StatefulInterface ****** //
    public function getFiniteState() {
        return $this->state;
    }

    public function setFiniteState($state) {
        $this->state = $state;
    }

    public function getIsEditableAttribute() {
        if ((strcmp($this->state, \Akzo\Scheme\State::CREATED) === 0)
            || (strcmp($this->state, \Akzo\Scheme\State::STAGED) === 0)
            || (strcmp($this->state, \Akzo\Scheme\State::UPDATE_REQUESTED) === 0)) {
            return true;
        }

        return false;
    }
    public function getIsDeletableAttribute() {
        if ((strcmp($this->state, \Akzo\Scheme\State::CREATED) === 0)
            || (strcmp($this->state, \Akzo\Scheme\State::STAGED) === 0)) {
            return true;
        }

        return false;
    }

    public function getComment() {
        if (isset($this->_comment) && !empty($this->_comment)) {
            return $this->_comment;
        }

        return null;
    }

    public function setComment($value) {
        $this->_comment = $value;
    }
}
