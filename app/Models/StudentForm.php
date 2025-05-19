<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentForm extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFormFactory> */
    use HasFactory;

    protected $fillable = [
        'student_form_link',
        'user_id',
        'office_id',
        'title',
        'status',
        'description'
    ];
}
