<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_name', 
        'class_teacher_id', 
        'class', 
        'admission_date',
        'yearly_fees',
        // add other fields here that are in $request->all()
    ];
     public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

}
