<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movements extends Model
{
    public $timestamps = false;
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'account_id', 'movement_category_id', 'date', 'description', 'type', 'value', 'created_at','start_balance','end_balance','document_id',
    ];

    public function associated_movement_type()
    {
        return $this->hasOne('App\MovementCategories', 'id', 'movement_category_id');

    }
}
