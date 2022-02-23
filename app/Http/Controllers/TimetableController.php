<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function get(Request $request){
        try {
            $query = (object)[];
            $group = DB::table('groups')
                ->where('id', $request->input('group_id'))
                ->value('name');
            $query->group = $group;

            $week = DB::table('weeks')
                ->where('id', $request->input('week_id'))
                ->value('name');
            $query->week = $week;


            $lessons= DB::table('lessons')
                /*->where('group_id', $request->input('group_id'))*/
                ->leftJoin('days', 'lessons.day_id', '=', 'days.id')
                ->where('days.week_id', $request->input('week_id'))
                /*->leftJoin('groups', 'lessons.group_id', '=', 'groups.id')*/
                ->leftJoin('subjects', 'lessons.subject_id', '=', 'subjects.id')
                ->leftJoin('teachers', 'lessons.teacher_id', '=', 'teachers.id')
                ->leftJoin('rooms', 'lessons.room_id', '=', 'rooms.id')
                ->select('subjects.name', 'teachers.first_name', 'teachers.last_name',
                'lessons.order', 'rooms.number as room_number', 'days.day', 'days.day_of_week')
                    ->get();
            $lessons = $lessons->groupBy('day');

            $query->lessons = $lessons;
            return parent::asJson($query);
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function addLesson(Request $request)
    {
        try {
            $id = DB::table('lessons')->insertGetId($request->all());
            return $id;
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
