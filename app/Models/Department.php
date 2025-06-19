<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'department_id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'parent_id', 'description',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'department_id');
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id', 'department_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id', 'department_id');
    }
}