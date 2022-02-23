<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::prefix('hr')->group(function () {*/

/*Route::post('teachers', [TeacherController::class, 'add']);*/
Route::get('teachers', [TeacherController::class, 'getActiveTeachers']);
Route::get('teachers/exited', [TeacherController::class, 'getExitedTeachers']);
Route::get('teachers/{id}', [TeacherController::class, 'getTeacherById']);
Route::post('teachers', [TeacherController::class, 'addTeacher']);
Route::put('teachers/{id}', [TeacherController::class, 'updateTeacherById']);
Route::delete('teachers/{id}', [TeacherController::class, 'deleteTeacherById']);

Route::get('students', [StudentController::class, 'getStudents']);
Route::get('students/{id}', [StudentController::class, 'getStudentById']);
Route::post('students', [StudentController::class, 'addStudent']);
Route::put('students/{id}', [StudentController::class, 'updateStudentById']);
Route::delete('students/{id}', [StudentController::class, 'deleteStudentById']);

Route::get('subjects', [SubjectController::class, 'getSubjects']);
Route::post('subjects', [SubjectController::class, 'addSubject']);

Route::get('groups', [GroupController::class, 'getGroups']);
Route::post('groups', [GroupController::class, 'addGroup']);

Route::get('timetable', [TimetableController::class, 'get']);
Route::post('lesson', [TimetableController::class, 'addLesson']);


/*Route::put('teachers/{id}', [TeacherController::class, 'update']);
Route::delete('teachers/{id}', [TeacherController::class, 'delete']);
Route::get('teachers/{id}', [TeacherController::class, 'getById']);*/


/*});*/
