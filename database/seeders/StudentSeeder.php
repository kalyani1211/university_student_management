<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Student::create([
        'student_name' => 'John Doe',
        'class_teacher_id' => 1,
        'class' => '10A',
        'admission_date' => '2023-01-15',
        'yearly_fees' => 1500,
    ]);
    }
}
