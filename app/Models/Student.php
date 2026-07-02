<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'full_name',
        'email',
        'mobile',
        'date_of_birth',
        'gender',
        'course',
        'department',
        'semester',
        'roll_number',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'profile_image',
        'admission_date',
        'fees',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'status' => 'boolean',
    ];
}