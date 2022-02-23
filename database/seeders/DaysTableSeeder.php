<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $year = 2022;
        $week = 1;
        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];
        $period = CarbonPeriod::create($year.'-09-15', ($year+1).'-01-31');
        foreach ($period as $key => $date) {
            if ($key !== array_key_first((array)$period))
                if($date->dayOfWeek == CarbonInterface::MONDAY)
                    $week++;
            $date->format('Y-m-d');
            DB::table('days')->insert(['day'=>$date, 'day_of_week'=>$weekMap[$date->dayOfWeek],
                'week_id'=>$week, 'semester'=>1]);
        }
    }
}
