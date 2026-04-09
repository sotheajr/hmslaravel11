<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationInformation extends Model
{
    protected $table = 'education_information';
    protected $fillable = [
        'user_id', 'institution', 'subject', 'start_date', 'end_date', 'degree', 'grade'
    ];
}