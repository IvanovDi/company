<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Employee;

class Position extends Model
{
    protected $fillable = [
        'name'
    ];

    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employee_position')->withTimestamps();
    }
}
