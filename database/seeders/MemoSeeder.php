<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class MemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
                'user_id' => '1',
                'plan_title' => 'かわえらについて',
                'record_at'=>'2023-09-07 20:00:00',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
        DB::table('todolists')->insert([
                'user_id' => '1',
                'todo_title' => 'のうきについて',
                'record_at'=>'2023-10-06 19:59:00',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
        DB::table('thinks')->insert([
                'user_id' => '1',
                'think_title' => 'kawaiiについて',
                'record_at'=>'2022-08-06 18:59:00',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
        ]);
    }
}