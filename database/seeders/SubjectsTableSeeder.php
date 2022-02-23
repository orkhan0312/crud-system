<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('groups')->truncate();

        $subjects = ['Algebra', 'Geometry', 'Physics', 'Chemistry', 'Astronomy', 'English', 'Literature',
            'History', 'Geography', 'Economics', 'Biology', 'Anatomy', 'French', 'Sports'];
        foreach ($subjects as $subject) {
            DB::table('subjects')->insert(['name' => $subject]);
        }
    }
}
