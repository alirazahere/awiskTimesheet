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
    protected $fillable = ['timein','timeout','timein_date','timeout_date','user_id','status'];

    protected $casts = [
        'timein' => 'datetime:Y-m-d',
    ];

    public function User(){
        return $this->belongsTo('App\User');
    }
}
