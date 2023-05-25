<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    public function index(){

        $students = Student::all();

        if (count($students) > 0){

            return response()->json([
                'status' => 200,
                'students' => $students

            ], 200);

        }
        else {

            return response()->json([
                'status' => 404,
                'message' => 'No Records Found!'

            ], 404);
        }

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'course' => 'required|max:255',
                'e_mail' => 'required|max:255|email|unique:students,e_mail',
                'phone' => 'required|digits:11'
            ]
        );

        if ($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else {

            $students = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'e_mail' => $request->e_mail,
                'phone' => $request->phone,

            ]);

            if ($students){

                return response()->json([
                    'status' => 200,
                    'message' => 'Student created successfully!'
                ], 200);
            }
            else {

                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong!'
                ], 500);
            }
        }
    }

    public function show($id){

        $student = Student::find($id);

        if ($student){

            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        }
        else {
            return response()->json([
                'status' => 404,
                'student' => 'No such student found!'
            ], 404);
        }
    }

    public function update(Request $request, int $id){

        $student = Student::find($id);

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'course' => 'required|max:255',
                'e_mail' => 'required|max:255|email|unique:students,e_mail',
                'phone' => 'required|digits:11'
            ]
        );

        if ($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }
        else {



            if ($student){

                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'e_mail' => $request->e_mail,
                    'phone' => $request->phone,

                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Student updated successfully!'
                ], 200);
            }
            else {

                return response()->json([
                    'status' => 404,
                    'message' => 'No such student found!'
                ], 404);
            }
        }
    }

    public function destroy($id){

        $student = Student::find($id);

        if ($student){

            $student->delete();

            return response()->json([
                'status' => 200,
                'student' => 'Deleted Successfully'
            ], 200);
        }
        else {
            return response()->json([
                'status' => 404,
                'student' => 'No such student found!'
            ], 404);
        }

    }
}
