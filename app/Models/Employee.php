<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees'; // Specify the table name if it's not pluralized
    
    protected $fillable = [ // Using Models
        'employee_id',
    ];

         public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Employee មាន Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Employee មាន Designation
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
     public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}