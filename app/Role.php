<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function User()
    {
        return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }

    public function UserRole(){
        return $this->hasMany('App\UserRole', 'role_id');
    }
}
