<?php
namespace Native5\Ui;

class Card extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'n5_ui_cards';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('\Akzo\User');
    }
    
}

