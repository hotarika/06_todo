<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TasksAsyncController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return DB::table('tasks')->where('user_id', Auth::id())->get()->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tasks = new Task;
        $tasks->content = $request->content;
        $tasks->created_at = Carbon::now();
        $tasks->updated_at = Carbon::now();
        $tasks->user_id = $request->user_id;
        $tasks->save();

        $lastId = DB::getPdo()->lastInsertId();
        return $lastId;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return DB::table('tasks')
        //     ->where('id', $id)
        //     ->where('user_id', Auth::id())
        //     ->get()->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDone(Request $request, $id)
    {
        $tasks = Task::where('id', $id)->first();
        $tasks->is_done = $request->is_done;
        $tasks->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateContent(Request $request, $id)
    {
        $tasks = Task::where('id', $id)->first();
        $tasks->content = $request->content;
        $tasks->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('tasks')->where('id', $id)->delete();
    }
}
