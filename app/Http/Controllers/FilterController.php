<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    static function filter(Request $request, $query)
    {
        try {
            if ($request->has('first_name')) {
                $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
            }
            if ($request->has('last_name')) {
                $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
            }
            if ($request->has('father_name')) {
                $query->where('father_name', 'like', '%' . $request->input('father_name') . '%');
            }
            if ($request->has('pin')) {
                $query->where('pin', 'like', '%' . $request->input('pin') . '%');
            }
            if ($request->has('gender')) {
                $query->where('gender', $request->input('gender'));
            }
            if ($request->has('min_salary')) {
                $query->where('salary', '>=', $request->input('min_salary'));
            }
            if ($request->has('max_salary')) {
                $query->where('salary', '<=', $request->input('max_salary'));
            }
            if ($request->has('group_id')) {
                $query->where('group_id', $request->input('group_id'));
            }
            return $query;
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }
}
