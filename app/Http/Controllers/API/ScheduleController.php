<?php

namespace App\Http\Controllers\API;
use App\Models\User;
use App\Models\CourseModel;
use App\Models\CourseEnroll;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['course','enroll_student','get_course','subject','get_subject','schedule','get_schedule']]);
    }


    public function schedule(Request $request)
    {

   
     $request->validate([
            'batch_id' => 'required|numeric|max:40',
            'url' => 'required|string|max:50',
            'course_id' => 'required|exists:courses,id|numeric|max:40',
            'start_date_time' => 'required|string|max:50',
            'end_date_time' => 'required|string|max:50',

        ]);
        $schdl = Schedule::create([
            'batch_id' => $request->batch_id,
            'url' => $request->url,
            'course_id' => $request->course_id,
            'start_date_time' => $request->start_date_time,
            'end_date_time' => $request->end_date_time,
   
        ]);

        return response()->json([
            'message' => 'successfully created',
            'data' =>  $schdl,
            'code' => '200'
        ]);
    }

    public function get_schedule(Request $request)
    {

    $subdetails = Schedule::get();
    $a=array(); 
        foreach($subdetails as $value){
            array_push($a,$value);
        }
        return response()->json([
            'message' => 'successfull',
            'data' => [$a,     
            ],
            'code' => '200'
        ]);
    }
}
