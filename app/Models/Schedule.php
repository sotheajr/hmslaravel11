<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'employee_id',
        'department_id',
        'designation_id',
        'shiftlist_id',
        'work_date',
    ];

    // Schedule សម្រាប់ Employee ម្នាក់
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Schedule សម្រាប់ Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Schedule សម្រាប់ Designation
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    
    public function details()
    {
        return $this->hasMany(ScheduleDetail::class);
    }
    public function shift()
{
    return $this->belongsTo(Shiftlist::class, 'shiftlist_id');
}
}