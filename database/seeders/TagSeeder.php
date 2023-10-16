<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'id' => '1',
                'name' => 'think',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
         DB::table('tags')->insert([
             'id' => '2',
                'name' => 'todolist',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
         DB::table('tags')->insert([
             'id' => '3',
                'name' => 'plan',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
         DB::table('tags')->insert([
             'id' => '4',
                'name' => 'memo',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
         ]);
    }
}
