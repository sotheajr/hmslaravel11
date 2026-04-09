<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyInformation extends Model
{
    protected $table = 'family_information';
    public $timestamps = true;

    // List all fields that can be mass assigned
    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'dob',
        'phone',
        'created_at',
        'updated_at'
    ];
}