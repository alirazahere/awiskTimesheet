<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function UserRole()
    {
        return $this->hasOne('App\UserRole', 'user_id');
    }

    public function Requests()
    {
        return $this->hasMany('App\Request', 'author');
    }

    public function Attendance()
    {
        return $this->hasMany('App\Attendance', 'user_id');
    }

}
