<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name'
    ];

    public function positions()
    {
        return $this->belongsToMany('App/Employee');
    }
}
