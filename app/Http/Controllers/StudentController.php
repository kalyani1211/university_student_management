<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Teacher;

class StudentController extends Controller
{
    //

    public function add_student(Request  $request)
    {
        return view("add_student");
    }
    public function edit_student(Request  $request)
    {
        return view("edit_student");
    }
    public function show_student(Request  $request)
    {
        return view("show_student");
    }

    public function add_student_data(Request $request)
    {

        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'class_teacher_id' => 'required|integer',
            'class' => 'required',
            'admission_date' => 'required|date',
            'yearly_fees' => 'required|numeric',
        ]);

        $id = $request->input('id');

        if (!empty($id)) {
            // code for update record
            $data = DB::table('students')
                ->where('id', $id)
                ->update([
                    'student_name' => $validated['student_name'],
                    'class_teacher_id' => $validated['class_teacher_id'],
                    'class' => $validated['class'],
                    'admission_date' => $validated['admission_date'],
                    'yearly_fees' => $validated['yearly_fees'],
                    'updated_at' => now()
                ]);
        } else {
            // code for insert record
            $data = DB::table('students')->insert([
                'student_name' => $validated['student_name'],
                'class_teacher_id' => $validated['class_teacher_id'],
                'class' => $validated['class'],
                'admission_date' => $validated['admission_date'],
                'yearly_fees' => $validated['yearly_fees'],
                'created_at' => now(),
            ]);
        }


        // Return appropriate response
        if ($data) {
            $msg = "Student added successfully";
            if (isset($id)) {
                $msg = "Student update successfully";
            }
            return response()->json([
                'status' => 'success',
                'message' => $msg,
                'code' => 200
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add student',
                'code' => 500
            ]);
        }
    }

    public function show_details(Request $request)
    {

        $data = DB::table('students')
            ->where('students.is_delete', '0')
            ->join('teachers', 'students.class_teacher_id', '=', 'teachers.id')
            ->select('students.*', 'teachers.teacher_name as tea_name')
            ->get();


        if (count($data) > 0) {
            return response()->json([
                "status" => "success",
                "code" => 200,
                "data" => $data
            ]);
        }
        return response()->json([
            "status" => "success",
            "code" => 200
        ]);
    }

    public function fetch_details(Request $request)
    {
        $id = $request->input("id");

        $data = DB::table('students')
            ->where('students.id', $id)
            ->join('teachers', 'students.class_teacher_id', '=', 'teachers.id')
            ->select('students.*', 'teachers.teacher_name as tea_name')
            ->get();

        if (count($data) > 0) {
            return response()->json([
                "status" => "success",
                "code" => 200,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "status" => "failed",
                "code" => 200,

            ]);
        }
    }

    function delete(Request $request)
    {
        // $studentId is the ID of the student you want to update
        $id = $request->input(('id'));
        if (!empty($id)) {
            $data = DB::table('students')
                ->where('id', $id)
                ->update([
                    'is_delete' => true,
                    'deleted_at' => now()
                ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Student record delete successfully',
                'code' => 200
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete student',
            'code' => 500
        ]);
    }

    function fetch_teachers(Request $request)
    {
        $query = DB::select("SELECT id , teacher_name FROM `teachers`");

        if (count($query) > 0) {
            return response()->json([
                "status" => "success",
                "code" => 200,
                "data" => $query
            ]);
        } else {
            return response()->json([
                "status" => "failed",
                "code" => 200,

            ]);
        }
    }
}
