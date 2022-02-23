<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    private string $main_table = 'groups';
    public function getGroups(Request $request)
    {
        try {
            $groups = DB::table($this->main_table)
                ->get();

            return parent::asJson($groups);
        } catch (\Exception $exception) {
            return parent::asJson(null, 'TRACE_ERROR', $exception->getMessage());
        }
    }

    public function addGroup(Request $request)
    {
        try {
            $id = DB::table($this->main_table)->insertGetId($request->all());
            return $id;
        } catch (\Exception $exception) {
            return parent::asJson(null,'TRACE_ERROR', $exception->getMessage());
        }
    }
}
