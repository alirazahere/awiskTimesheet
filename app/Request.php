<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'message', 'author', 'status','attendance_id','timein','timeout'];
    public $timestamps = false;

    public function User()
    {
        return $this->belongsTo('App\User','id');
    }
}
