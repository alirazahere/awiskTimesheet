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
    protected $fillable = ['subject','message','author','status'];

    public function User(){
              $this->belongsTo('App\User');
    }
}
