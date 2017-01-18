<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'main_employee_id',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_group')->withTimestamps();
    }

    public function mainGroupEmployee()
    {
        return $this->belongsTo(Employee::class, 'main_employee_id');
    }
}
