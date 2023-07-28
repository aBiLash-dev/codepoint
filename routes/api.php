<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\SubjectController;
use App\Http\Controllers\API\ScheduleController;


Route::controller(AuthController::class)->group(function () {
    Route::post('auth/login', 'login');
    Route::post('auth/register', 'register');
    Route::post('auth/logout', 'logout');
    Route::post('auth/refresh', 'refresh');
});
Route::controller(CourseController::class)->group(function () {
    Route::post('course', 'course');
     Route::post('course/{id}/enroll-student', 'enroll_student');
     Route::get('course','get_course');

});

// Route::post('course/enroll-student/{id}', 'CourseController@enroll_student'); 

Route::controller(SubjectController::class)->group(function () {
    Route::post('subject', 'subject');
    Route::get('subject','get_subject');

});
Route::controller(ScheduleController::class)->group(function () {
    Route::post('schedule', 'schedule');
    Route::get('schedule','get_schedule');

});