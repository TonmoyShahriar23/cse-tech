<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    use HasFactory;

    
    protected $fillable = ['name', 'student_id', 'age'];

    
    protected $table = 'students';
}
