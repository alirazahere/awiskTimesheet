<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'message', 'author', 'status','attendance_id','timein','timeout'];

    public function User()
    {
        return $this->belongsTo('App\User','author');
    }
    public function Attendance()
    {
        return $this->belongsTo('App\Attendance','attendance_id');
    }
}
