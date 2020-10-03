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
            'content' => 'ユーザー1：野菜を買う',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1
        ]);
        DB::table('tasks')->insert([
            'id' => 2,
            'content' => 'ユーザー1：部屋を片付ける',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 1
        ]);
        DB::table('tasks')->insert([
            'id' => 3,
            'content' => 'ユーザー2：カレーを作る',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => 2
        ]);
    }
}
