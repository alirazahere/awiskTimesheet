<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['timein','timeout','user_id','status'];
    public function User(){
        return $this->belongsTo('App\User');
    }
}
