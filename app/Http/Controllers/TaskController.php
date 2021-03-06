<?php

namespace App\Http\Controllers;

use App\Http\Utils\Utils;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Project;
use App\Task;
use App\Level;
use App\Status;
use App\User;

use Validator;
use Carbon\Carbon;
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

    public function show($id)
    {
        $task = Task::get()->where('slug', $id)->first();
        return view('task.show', compact('task'));
    }

    public function createTask($id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        $levels = Level::get();
        return view('task.create', compact(['project', 'levels']));
    }

    public function store(StoreTaskRequest $request)
    {
        $project = Project::findOrFail($request->project_id);
        $dateTaskStart = date("Y-m-d H:i:s", strtotime($request->start));
        $dateTaskEnd = date("Y-m-d H:i:s", strtotime($request->end));
        $levels = Level::get();

        $validator = Validator::make($request->all(), []);

        $validator->after(function ($validator) use ($request, $project) {
            $start = Carbon::createFromFormat('d-m-Y', $request->start);
            $end = Carbon::createFromFormat('d-m-Y', $request->end)->subDay();

            if ($start->lt($project->start)) {
                $validator->errors()->add('start', 'Starting date need to be greater than project starting date');
            }

            if ($end->gt($project->end)) {
                $validator->errors()->add('end', 'Ending date need to be smaller than project ending date');
            }

        });

        if ($validator->fails()) {
            flash($validator->errors()->first())->error();
            return redirect()->back()->withInput();
        }

        $task = new Task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->start = $dateTaskStart;
        $task->end = $dateTaskEnd;
        $task->project_id = $request->project_id;
        $task->user_id = Auth::user()->id;
        $task->level_id = $request->level_id;
        $task->status_id = 1;
        $task->save();

        flash('Task successfully registered')->success();
        return redirect(route('project.show', $project->slug));
    }

    public function link($id)
    {
        $task = Task::get()->where('slug', $id)->first();
        $userInTask = $task->user;
        $usersInProject = $task->project->users;
        $users = Utils::check_diff_multi($usersInProject, $userInTask);
        return view('task.link', compact(['task', 'users']));
    }

    public function linkUserTask(Request $request, $task)
    {
        $task = Task::findOrFail($task);
        $task->user_id = $request->user_id;
        $task->save();

        flash('User successfully assigned to the task')->success();
        return redirect(route('project.show', $task->project->slug));
    }

    public function edit($id)
    {
        $task = Task::get()->where('slug', $id)->first();
        $levels = Level::get();
        $statuses = Status::get();
        return view('task.edit', compact(['task', 'levels', 'statuses']));
    }

    public function update(StoreTaskRequest $request, $id)
    {
        $task = Task::get()->where('slug', $id)->first();
        $validator = Validator::make($request->all(), []);

        $validator->after(function ($validator) use ($request, $task) {
            $start = Carbon::createFromFormat('Y-m-d', $request->start);
            $end = Carbon::createFromFormat('Y-m-d', $request->end)->subDay();

            if ($start->lt($task->project->start)) {
                $validator->errors()->add('start', 'Starting date need to be greater than project starting date');
            }

            if ($end->gt($task->project->end)) {
                $validator->errors()->add('end', 'Ending date need to be smaller than project ending date');
            }

        });

        if ($validator->fails()) {
            flash($validator->errors()->first())->error();
            return redirect()->back()->withInput();
        }

        $task->name = $request->name;
        $task->description = $request->description;
        $task->start = date("Y-m-d H:i:s", strtotime($request->start));
        $task->end = date("Y-m-d H:i:s", strtotime($request->end));
        $task->status_id = $request->status_id;
        $task->level_id = $request->level_id;
        $task->save();

        flash('Task successfully updated')->success();
        return redirect(route('project.show', $task->project->slug));
    }

    public function destroy($task)
    {
        $task = Task::findOrFail($task);
        $task->delete();

        flash('Task successfully deleted')->success();
        return redirect(route('project.show', $task->project->slug));
    }
}
