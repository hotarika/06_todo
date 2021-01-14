<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            'id' => 1,
            'content' => '野菜を買う',
            'is_done' => false,
            'edit_mode' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1
        ]);
        DB::table('tasks')->insert([
            'id' => 2,
            'content' => '部屋を片付ける',
            'is_done' => false,
            'edit_mode' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1
        ]);
        DB::table('tasks')->insert([
            'id' => 3,
            'content' => '部屋を片付ける',
            'is_done' => false,
            'edit_mode' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 2
        ]);
    }
}
