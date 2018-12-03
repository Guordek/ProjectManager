<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Project;
use App\Task;
use App\Level;
use App\Status;
use App\User;

use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function show($id) {
        $task = Task::findOrFail($id);
        return view('task.show', compact('task'));
    }

    public function createTask($id) {
        $project = Auth::user()->projects->where('id', $id)->first();
        $levels = Level::get();
        return view('task.create', compact(['project', 'levels']));
    }

    public function store(StoreTaskRequest $request) {
        $project = Project::findOrFail($request->project_id);
        $dateTaskStart = date("Y-m-d H:i:s", strtotime($request->start));
        $datetaskEnd = date("Y-m-d H:i:s", strtotime($request->end));
        $levels = Level::get();

        if(!$request->validated()) {
          flash('Error when creating task. Check starting and ending date')->error();
          return redirect()->back();
        } else {
          $task = new Task;
          $task->name = $request->name;
          $task->description = $request->description;
          $task->start = $dateTaskStart;
          $task->end = $datetaskEnd;
          $task->project_id = $request->project_id;
          $task->user_id = Auth::user()->id;
          $task->level_id = $request->level_id;
          $task->status_id = 1;
          $task->save();

          flash('Task successfully registered')->success();
          return redirect(route('project.show', $request->project_id));
        }
    }

    public function link($id){
      $task = Task::findOrFail($id);
      $userInTask = $task->user;
      $usersInProject = $task->project->users;
      $users = $this->check_diff_multi($usersInProject, $userInTask);
      return view('task.link', compact(['task', 'users']));
    }

    public function linkUserTask(Request $request, $task) {
      $task = Task::findOrFail($task);
      $task->user_id = $request->user_id;
      $task->save();

      flash('User successfully assigned to the task')->success();
      return redirect(route('project.show', $task->project->id));
    }

    public function edit($id) {
        $task = Task::findOrFail($id);
        $levels = Level::get();
        $statuses = Status::get();
        return view('task.edit', compact(['task', 'levels', 'statuses']));
    }

    public function update(StoreTaskRequest $request, $id) {
        $task = Task::findOrFail($id);
        $project = $task->project;
        $dateTaskStart = date("Y-m-d H:i:s", strtotime($request->start));
        $datetaskEnd = date("Y-m-d H:i:s", strtotime($request->end));
        $levels = Level::get();

        if(!$request->validated()) {
          flash('Error when creating task. Check starting and ending date')->error();
          return redirect()->back();
        } else {
          $task->name = $request->name;
          $task->description = $request->description;
          $task->start = date("Y-m-d H:i:s", strtotime($request->start));
          $task->end = date("Y-m-d H:i:s", strtotime($request->end));
          $task->status_id = $request->status_id;
          $task->level_id = $request->level_id;
          $task->save();

          flash('Task successfully updated')->success();
          return redirect(route('project.show', $task->project->id));
        }
    }

    public function destroy($task) {
        $task = Task::findOrFail($task);
        $task->delete();

        flash('Task successfully deleted')->success();
        return redirect(route('project.show', $task->project_id));
    }

    public function check_diff_multi($array1, $array2){
      $result = array();
      foreach($array1 as $key => $val) {
           if(isset($array2[$key])){
             if(is_array($val) && $array2[$key]){
                 $result[$key] = check_diff_multi($val, $array2[$key]);
             }
         } else {
             $result[$key] = $val;
         }
      }
      return $result;
    }
}
