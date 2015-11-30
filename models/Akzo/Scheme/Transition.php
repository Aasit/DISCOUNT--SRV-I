<?php
namespace Akzo\Scheme;

class Transition extends \Native5\Product\Model\Model
{
    protected $table = 'ak_discounts_scheme_transitions';
    protected $primaryKey = 'id';
    protected $hidden = array(
        'id'
    );
    protected $appends = array('date', 'time');

    public function getDateAttribute()
    {
        return date_format($this->created_at, 'd M Y');
    }

    public function getTimeAttribute()
    {
        return date_format($this->created_at, 'g:i A');
    }

    public function scheme()
    {
        return $this->belongsTo('\Akzo\Scheme', 'scheme_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\Akzo\User', 'user_id', 'id');
    }
}

