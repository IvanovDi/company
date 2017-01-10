<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    protected $fillable = [
        'name',
        'relation'
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
