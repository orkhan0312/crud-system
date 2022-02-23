<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    private string $main_table = 'subjects';
    public function getSubjects(Request $request)
    {
        try {
            $query = DB::table($this->main_table);
            if ($request->has('teacher_id')) {
                $query->leftJoin('teachers_subjects', 'teachers_subjects.subject_id', '=', 'subjects.id')
                    ->where('teachers_subjects.teacher_id', $request->input('teacher_id'));
            }
            $subjects = $query->select('subjects.id', 'subjects.name')
                ->get();
            return parent::asJson($subjects);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function addSubject(Request $request)
    {
        try {
            $id = DB::table($this->main_table)->insertGetId($request->all());
            return $id;
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
