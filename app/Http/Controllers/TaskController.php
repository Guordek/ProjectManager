<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Project;
use App\Task;
use App\Level;

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

    public function create($id) {

    }

    public function createTask($id) {
        $project = Auth::user()->projects->where('id', $id)->first();
        $levels = Level::get();
        return view('task.create', compact(['project', 'levels']));
    }

    public function store(Request $request) {
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

    public function destroy($task) {
        $task = Task::findOrFail($task);
        $task->delete();
        return redirect(route('project.show', $task->project_id));
    }
}
