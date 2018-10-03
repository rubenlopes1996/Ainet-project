<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Documents extends Model
{
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'type', 'original_name', 'description', 'created_at'
    ];

    public function hasMovement()
    {
        return $this->hasOne('App\Movements', 'document_id', 'id');
    }

}
