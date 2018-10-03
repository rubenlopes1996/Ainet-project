<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'profile_photo', 'password', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function typeToStr()
    {
        switch ($this->admin) {
            case 0:
                return 'Client';
            case 1:
                return 'Administrator';
        }

        return 'Unknown';
    }

    public function isBlocked()
    {
        switch ($this->blocked) {
            case 0:
                return 'Active';
            case 1:
                return 'Blocked';
        }
    }

    public function isAdmin()
    {
        return $this->admin == '1';
    }

    public function isClient()
    {
        return $this->admin == '0';
    }

    public function associated_members()
    {
        //Associated
        return $this->belongsToMany('App\User', 'associate_members', 'associated_user_id', 'main_user_id');

    }

    public function associated()
    {
        //Associated Of
        return $this->belongsToMany('App\User', 'associate_members', 'main_user_id', 'associated_user_id');

    }

    public function accounts()
    {
        return $this->hasMany('App\Accounts', 'owner_id', 'id');
    }


}
