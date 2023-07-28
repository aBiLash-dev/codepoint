<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Models\CourseModel;
use App\Models\CourseEnroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['course','enroll_student','get_course']]);
    }
    public function course(Request $request)
    {
   
     $request->validate([
            'name' => 'required|string|max:25',
            'description' => 'required|string|max:100',
            'fee' => 'required|string|max:40',
            'max_student' => 'required|string|max:20',     
            'total_duration_in_days' => 'required|string|email|max:255|unique:users',
        ]);
        $course = CourseModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'fee' => $request->fee,
            'max_student' => $request->max_student,
            'total_duration_in_days' => $request->total_duration_in_days,
        ]);

        return response()->json([
            'message' => 'successfully created',
            'code' => '200'
        ]);
    }
    public function enroll_student(Request $request ,$id)
    {
        $data=$request->all();
        $val=$data['student_ids']; 
        $value=explode(",",$val); 
        foreach($value as $val){
           
            $CourseEnroll = CourseEnroll::create([
                'courseID' => $id,
                'studID' => $val,
            ]);
        }
        return response()->json([
            'message' => 'successfully enrolled',
            'code' => '200'
        ]);
    }

    public function get_course(Request $request)
    {
        $users = CourseModel::join('courses_enroll', 'courses_enroll.courseID', '=', 'courses.id')
    ->join('users', 'users.id', '=', 'courses_enroll.studID')
    ->get();
    $a=array();

        
        foreach($users as $value){
            array_push($a,$value);
        }
        return response()->json([
            'message' => 'successfull',
            'data' => [
           
                'entrolled_students'=> $a,
                
            ],
          
        ]);
    }

    
}
