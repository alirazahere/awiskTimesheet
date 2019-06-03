<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['timein', 'timeout', 'user_id', 'status'];
    public $timestamps = false;

    public function User()
    {
        return $this->belongsTo('App\User');
    }
    public function AttendanceRequest()
    {
        return $this->hasMany('App\Requests', 'attendance_id');
    }
}
