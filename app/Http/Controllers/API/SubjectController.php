<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Models\CourseModel;
use App\Models\CourseEnroll;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['course','enroll_student','get_course','subject','get_subject']]);
    }

    public function subject(Request $request)
    {

     $request->validate([
            'name' => 'required|string|max:25',
            'description' => 'required|string|max:400',
            'course_id' => 'required|exists:courses,id|numeric|max:40',

        ]);
        $course = Subject::create([
            'sub_name' => $request->name,
            'description' => $request->description,
            'courseID' => $request->course_id,
   
        ]);

        return response()->json([
            'message' => 'successfully created',
            'code' => '200'
        ]);
    }

    public function get_subject(Request $request)
    {

    $subdetails = subject::join('courses', 'courses.id', '=', 'subject.courseID')
    ->get();
    $a=array(); 
        foreach($subdetails as $value){
            array_push($a,$value);
        }
        return response()->json([
            'message' => 'successfull',
            'data' => [
           
                 $a,
                
            ],
            'code' => '200'
        ]);
    }
}
