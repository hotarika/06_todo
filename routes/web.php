<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    // return redirect('todo');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('/', 'TodoController@index')->name('todo');

// async
// Route::resource('json', 'TasksAsyncController');
Route::post('json', 'TasksAsyncController@store');
Route::post('json/done_{id}', 'TasksAsyncController@updateDone');
Route::post('json/cont_{id}', 'TasksAsyncController@updateContent');
Route::delete('json/{id}', 'TasksAsyncController@destroy');
