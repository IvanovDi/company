<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'relation',
        'deleted_at'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function relations()
    {
        return $this->belongsTo(Employee::class, 'relation');
    }
}
