<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'project',
        'date',
        'assigned_hours',
        'worked_hours',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}