<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Position;
use Group;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'group_id',
        'position_id'
    ];

    public function positions()
    {
        return $this->belongsToMany('App\Position', 'employee_position')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsTo('App\Group');
    }
}
