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

    public function Role()
    {
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function UserRequest()
    {
        return $this->hasMany('App\Requests', 'author');
    }

    public function Attendance()
    {
        return $this->hasMany('App\Attendance', 'user_id');
    }

}
