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
Route::get('/project/{id}/task/link', 'TaskController@link')->name('task.link');
Route::post('/project/{id}/task/link', 'TaskController@linkUserTask')->name('task.linkUserTask');
Route::get('/project/{id}/user/link', 'ProjectController@formLinkUserProject')->name('project.formLinkUserProject');
Route::post('/project/{id}/user/link', 'ProjectController@linkUserProject')->name('project.linkUserProject');
Route::post('/project/{id}/user/owner', 'ProjectController@changeOwnerProject')->name('project.changeOwnerProject');
Route::get('/project/{id}/file', 'ProjectController@addFileForm')->name('project.addFileForm');
Route::get('/project/{id}/download/{path}', 'ProjectController@dlFile')->name('project.dlFile');
Route::delete('/project/{id}/delete/{path}', 'ProjectController@deleteFile')->name('project.deleteFile');
Route::post('/project/{id}/file/add', 'ProjectController@addFile')->name('project.addFile');
Route::delete('/project/{project}/user/{id}/delete', 'ProjectController@removeUserFromProject')->name('project.removeUserFromProject');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', 'AdminController@index')->name('admin.index');
});
