<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'main_employee_id',
        'deleted_at'
    ];

    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employee_group')->withTimestamps();
    }

    public function relations()
    {
        return $this->belongsTo(Employee::class, 'main_employee_id');
    }
}
