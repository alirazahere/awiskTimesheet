<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'role_id',
        'user_id'
    ];

    public function Role(){
        return $this->belongsTo('App\Role','id');
    }
}
