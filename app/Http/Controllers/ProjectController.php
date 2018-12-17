<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProjectFilesRequest;
use App\Http\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;

use App\Project;
use App\Category;
use App\Status;
use App\User;
use App\ProjectFile;

use App\Http\Requests\StoreProjectRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
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
        $user = Auth::user();
        $projects = $user->projects->sortBy('end');
        return view('project.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        $tasks = $project->tasks;
        $date = date("Y-m-d");
        $statusClosed = Status::get()->where('name', 'Closed')->first();
        $nbrTaskComplete = $project->tasks->where('status_id', $statusClosed->id)->count();
        if ($nbrTaskComplete != 0) {
            $progress = round($nbrTaskComplete / $project->tasks->count() * 100, 2);
        } else {
            $progress = 0;
        }

        $events = [];

        if (!empty($tasks)) {
            foreach ($tasks as $value) {
                $events[] = \Calendar::event(
                    ($value->user_id != null ? $value->user->name : 'Unassigned') . ' - ' . $value->name . ' [' . $value->status->name . ']',
                    true,
                    $value->start,
                    $value->end->addDays(1), // to display correctly in calendar
                    $value->id,
                    [
                        'url' => route('task.show', $value->slug),
                        'color' => ($value->level->color != null) ? $value->level->color : "#1db5ff",
                    ]
                );
            }
        }

        $calendar = \Calendar::addEvents($events)->setOptions([
            'firstDay' => 1,
        ]);

        return view('project.show', compact(['project', 'progress', 'date', 'calendar']));
    }

    public function create()
    {
        $categories = Category::get();
        return view('project.create', compact(['categories']));
    }

    public function store(StoreProjectRequest $request)
    {
        $user = Auth::user()->id;
        $project = new Project;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->start = date("Y-m-d H:i:s", strtotime($request->start));
        $project->end = date("Y-m-d H:i:s", strtotime($request->end));
        $project->category_id = $request->category_id;
        $project->status_id = 1;
        $project->created_by = $user;
        $project->save();
        $project->users()->sync($user);
        flash('Project successfully stored')->success();
        return redirect(route('project.index'));
    }

    public function edit($id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        $categories = Category::get();
        $statuses = Status::get();
        return view('project.edit', compact(['project', 'categories', 'statuses']));
    }

    public function update(StoreProjectRequest $request, $id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->start = date("Y-m-d H:i:s", strtotime($request->start));
        $project->end = date("Y-m-d H:i:s", strtotime($request->end));
        $project->category_id = $request->category_id;
        $project->status_id = $request->status_id;
        $project->save();

        flash('Project successfully updated')->success();
        return redirect(route('project.show', $project->slug));
    }

    public function formLinkUserProject($id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        $usersInProject = $project->users;
        $allUsers = User::get();
        $users = Utils::check_diff_multi($allUsers, $usersInProject);
        return view('project.link', compact(['project', 'users']));
    }

    public function linkUserProject(Request $request)
    {
        if ($request->user_id != null) {
            $project = Auth::user()->projects->where('id', $request->project_id)->first();
            $user = User::get()->where('id', $request->user_id)->first();
            $query = DB::table('project_user')
                ->select('project_id', 'user_id')
                ->where([
                    ['project_id', $project->id],
                    ['user_id', $user->id],
                ])->get();

            if ($query->isEmpty()) {
                DB::table('project_user')->insert(
                    ['project_id' => $project->id, 'user_id' => $user->id]
                );

                flash('User successfully added to the project')->success();
                return redirect(route('project.show', $project->slug));
            } else {
                flash('User already exists in this project')->error();
                return redirect()->back();
            }
        } else {
            flash('You need to select a user')->error();
            return redirect()->back();
        }
    }

    public function changeOwnerProject(Request $request, $id)
    {
        $project = Auth::user()->projects->where('id', $id)->first();
        $project->created_by = $request->user_id;
        $project->save();

        flash('The owner of the project is successfully changed')->success();
        return redirect()->back();
    }

    public function removeUserFromProject($id, $project)
    {
        $user = User::get()->where('id', $id)->first();
        $user->projects()->detach($project);
        $project = Auth::user()->projects->where('id', $project)->first();
        foreach ($project->tasks as $task) {
            if ($task->user_id == $id) {
                $task->user_id = null;
                $task->save();
            }
        }

        flash('User successfully removed from the project')->success();
        return redirect()->back();
    }

    public function addFileForm($id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        return view('project.file', compact(['project']));
    }

    public function addFile(UploadProjectFilesRequest $request, $id)
    {
        $project = Auth::user()->projects->where('id', $id)->first();
        $user = Auth::user();

        foreach ($request->files as $file) {
            foreach ($file as $index => $f) {
                $path = $request->file('files')[$index]->store('public/files');
                $filename = $request->file('files')[$index]->getClientOriginalName();
                $f = new ProjectFile;
                $f->path = str_replace("public/", "", $path);
                $f->filename = $filename;
                $f->user_id = $user->id;
                $f->project_id = $project->id;
                $f->save();
            }
        }

        return redirect(route('project.show', $project->slug));
    }

    public function dlFile($idProject, $id) {
        $project = Auth::user()->projects->where('slug', $idProject)->first();
        $file = $project->files()->where('id', $id)->first();

        return response()->download('storage/'. $file->path, $file->filename);
    }

    public function deleteFile($idProject, $id) {
        $project = Auth::user()->projects->where('slug', $idProject)->first();
        $file = $project->files()->where('id', $id)->first();

        Storage::delete('public/'. $file->path);
        ProjectFile::destroy($file->id);

        flash('File successfully deleted')->success();
        return redirect(route('project.show', $project->slug));
    }

    public function destroy($id)
    {
        $project = Auth::user()->projects->where('slug', $id)->first();
        $project->delete();

        flash('Project successfully deleted')->success();
        return redirect(route('project.index'));
    }
}
