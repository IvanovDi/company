<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name'
    ];

    public function positions()
    {
        return $this->belongsToMany('App/Position');
    }

    public function groups()
    {
        return $this->belongsTo('App/Group');
    }
}
