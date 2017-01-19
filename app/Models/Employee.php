<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Position;
use App\Models\Group;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'group_id',
        'position_id',
        'main_employee_id',
        'team_lead',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'employee_position')->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'employee_group')->withTimestamps();
    }

    public function mainEmployee()
    {
        return $this->hasOne(Employee::class, 'id', 'main_employee_id');
    }

    public function subordinatesGroups()
    {
        return $this->hasMany(Group::class, 'main_employee_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'main_employee_id');
    }

//    public function getFullName()
//    {
//        return $this->first_name . ' ' . $this->last_name;
//    }
}
