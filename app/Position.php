<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Employee;

class Position extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'deleted_at'
    ];

    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employee_position')->withTimestamps();
    }
}
