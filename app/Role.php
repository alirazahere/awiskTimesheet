<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function UserRole(){
        return $this->belongsTo('App\UserRole');
    }
}
