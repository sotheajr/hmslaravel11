<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shiftlist extends Model
{
    protected $fillable = [
    'shift_name',
    'min_start_time',
    'start_time',
    'max_start_time',
    'min_end_time',
    'end_time',
    'max_end_time',
    'break_time',
    'status',
];
public function schedules()
{
    return $this->hasMany(Schedule::class);
}
}