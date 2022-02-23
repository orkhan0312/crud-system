<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    private string $main_table = 'teachers';
    public function getActiveTeachers(Request $request)
    {
        try {
            $query = DB::table($this->main_table)->whereNull(['finished_work_at', 'deleted_at']);
            $query = FilterController::filter($request, $query);
            if ($request->has('subject_id')) {
                $query->leftJoin('teachers_subjects', 'teachers_subjects.teacher_id', '=', 'teachers.id')
                    ->where('teachers_subjects.subject_id', $request->input('subject_id'));
            }
            $teachers = $query->select('teachers.id', 'teachers.first_name', 'teachers.last_name',
                'teachers.pin', 'teachers.salary')
                ->get();
            return parent::asJson($teachers);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getExitedTeachers()
    {
        try {
            $teachers = DB::table($this->main_table)->whereNotNull('finished_work_at')
                ->whereNull('deleted_at')
                ->select('id', 'name', 'surname', 'pin', 'salary')
                ->get();
            return parent::asJson($teachers);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function getTeacherById(Request $request, $id)
    {
        try {
            $teacher = DB::table($this->main_table)->where('id', $id)
                ->select('id', 'first_name', 'last_name', 'father_name', 'pin', 'salary',
                    'date_of_birth', 'gender')
                ->first();
            $subjects = DB::table('teachers_subjects')->where('teachers_subjects.teacher_id', $id)
                ->leftJoin('subjects', 'teachers_subjects.subject_id', '=', 'subjects.id')
                ->select('subjects.name')->get();
            $teacher->subjects = $subjects;
            return parent::asJson($teacher);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    /*public function getDeletedTeachers(Request $request)
    {
        try {
            $teachers = DB::table($this->main_table)->whereNotNull('deleted_at')
                ->select('id', 'name', 'surname', 'pin', 'salary')
                ->get();
            return parent::asJson($teachers);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }*/

    public function addTeacher(Request $request)
    {
        try {
            $id = DB::table($this->main_table)->insertGetId($request->all());
            return $id;
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function updateTeacherById(Request $request, $id)
    {
        try {
            DB::table('teachers')
                ->where('id', '=', $id)
                ->update($request->all());
            return parent::asJson(['success' => true]);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function deleteTeacherById(Request $request, $id)
    {
        try {
            DB::table('teachers')
                ->where('id', '=', $id)
                ->update(['deleted_at' => Carbon::now('UTC')]);
            return parent::asJson(['success' => true]);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
