<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accounts extends Model
{
    use softdeletes;
    public $timestamps = false;


    protected $fillable = [
        'owner_id', 'account_type_id', 'code', 'date', 'description', 'start_balance', 'current_balance', 'created_at'
    ];

    public function accounts_user()
    {
        return $this->hasOne('App\User', 'id', 'owner_id');
    }

    public function associated_account_type()
    {
        return $this->hasOne('App\Account_types', 'id', 'account_type_id');

    }

    public function movementsAccount()
    {
        return $this->hasMany('App\Movements', 'id', 'account_id');
    }

    public function hasMovements()
    {
        return $this->hasMany('App\Movements', 'account_id', 'id');
    }
}
