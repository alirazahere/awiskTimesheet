<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public function Role()
    {
        return $this->belongsTo('App\Role');
    }
}
