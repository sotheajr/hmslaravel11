<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    protected $fillable = [
        'schedule_id',
        'work_date',
        'start_time',
        'end_time',
        'break_time',
        'total_hours'
    ];

    // ScheduleDetail សម្រាប់ Schedule មួយ
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}