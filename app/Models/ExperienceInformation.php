<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceInformation extends Model
{
    use HasFactory;

    protected $table = 'experience_information';

    protected $fillable = [
        'user_id',
        'company_name',
        'location',
        'job_position',
        'period_from',
        'period_to',
    ];
}