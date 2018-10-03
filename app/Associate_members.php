<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associate_members extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'main_user_id', 'associated_user_id','created_at'
    ];
}
