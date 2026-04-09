<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',         // ឈ្មោះ designation
        'department_id' // FK department
    ];

    // Relationship to department
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Designation មាន Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Designation ត្រូវបានភ្ជាប់ទៅ Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}