<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Project;
use App\Task;
use App\Level;
use App\Status;
use App\User;

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
      return redirect(route('project.show', $task->project->id));
    }

    public function store(Request $request) {
        if($request->end < $request->start) {
          return redirect(route('project.show', $request->project_id));
        } else {
          $task = new Task;
          $task->name = $request->name;
          $task->description = $request->description;
          $task->start = date("Y-m-d H:i:s", strtotime($request->start));
          $task->end = date("Y-m-d H:i:s", strtotime($request->end));
          $task->project_id = $request->project_id;
          $task->user_id = Auth::user()->id;
          $task->level_id = $request->level_id;
          $task->status_id = 1;
          $task->save();
          return redirect(route('project.show', $request->project_id));
        }
    }

    public function edit($id) {
        $task = Task::findOrFail($id);
        $levels = Level::get();
        $statuses = Status::get();
        return view('task.edit', compact(['task', 'levels', 'statuses']));
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->start = date("Y-m-d H:i:s", strtotime($request->start));
        $task->end = date("Y-m-d H:i:s", strtotime($request->end));
        $task->status_id = $request->status_id;
        $task->level_id = $request->level_id;
        $task->save();
        return redirect(route('project.show', $task->project->id));
    }

    public function destroy($task) {
        $task = Task::findOrFail($task);
        $task->delete();
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
