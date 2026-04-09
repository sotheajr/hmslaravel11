<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
    ];

    // Department មាន Employees
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Department មាន Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}