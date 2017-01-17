<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Position;


class Employee extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'group_id',
        'position_id',
        'main_employee_id',
        'team_lead',
        'deleted_at'
    ];

    public function positions()
    {
        return $this->belongsToMany('App\Position', 'employee_position')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group', 'employee_group')->withTimestamps();
    }

    public function relations()
    {
        return $this->hasMany(Employee::class, 'main_employee_id');
    }

    public function relationGroup()
    {
        return $this->hasMany(Group::class, 'main_employee_id');
    }
}
