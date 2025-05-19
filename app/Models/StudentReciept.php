<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentReciept extends Model
{
    /** @use HasFactory<\Database\Factories\StudentRecieptFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receipt_link',
        'title',
        'status',
        'description',
        'office_id',
    ];
}
