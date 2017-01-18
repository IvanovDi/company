<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Employee;

class Position extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'deleted_at'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_position')->withTimestamps();
    }
}
