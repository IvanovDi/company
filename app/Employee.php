<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Position;


class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'group_id',
        'position_id',
        'relation'
    ];

    public function positions()
    {
        return $this->belongsToMany('App\Position', 'employee_position')->withTimestamps();
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
