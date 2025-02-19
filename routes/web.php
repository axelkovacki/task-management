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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/tasks', 'TasksController@get');
    Route::put('/tasks/{id}', 'TasksController@update');
    Route::post('/tasks', 'TasksController@create');
    Route::delete('/tasks/{id}', 'TasksController@delete');
});

