<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    private string $main_table = 'students';
    public function getStudents(Request $request)
    {
        try {
            $query = DB::table($this->main_table)->whereNull(['deleted_at']);
            $query = FilterController::filter($request, $query);
            $students = $query
                ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                ->select('students.id', 'students.first_name', 'students.last_name', 'students.pin', 'groups.name')
                ->get();

            return parent::asJson($students);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getStudentById(Request $request, $id)
    {
        try {
            $student = DB::table($this->main_table)->where('students.id', $id)
                ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                ->select('students.id', 'students.first_name', 'students.last_name',
                    'students.father_name', 'students.pin', 'students.date_of_birth',
                    'students.gender', 'groups.name as group_name')
                ->first();
            return parent::asJson($student);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function addStudent(Request $request)
    {
        try {
            $id = DB::table($this->main_table)->insertGetId($request->all());
            return $id;
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function updateStudentById(Request $request, $id)
    {
        try {
            DB::table($this->main_table)
                ->where('id', '=', $id)
                ->update($request->all());
            return parent::asJson(['success' => true]);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function deleteStudentById(Request $request, $id)
    {
        try {
            DB::table($this->main_table)
                ->where('id', '=', $id)
                ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
            return parent::asJson(['success' => true]);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
