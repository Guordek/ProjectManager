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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('project', 'ProjectController');
Route::resource('task', 'TaskController');
Route::resource('comment', 'CommentController');
Route::get('/project/{id}/task/create', 'TaskController@createTask')->name('task.createTask');
Route::get('/project/{id}/user/link', 'ProjectController@formLinkUserProject')->name('project.formLinkUserProject');
Route::post('/project/{id}/user/link', 'ProjectController@linkUserProject')->name('project.linkUserProject');
