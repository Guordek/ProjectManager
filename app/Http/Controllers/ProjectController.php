<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Project;
use App\Category;
use App\Status;

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
      $projects = $user->projects;
      return view('project.index', compact('projects'));
    }

    public function show($id) {
      $project = Project::findOrFail($id);
      return view('project.show', compact('project'));
    }

    public function create() {
      $categories = Category::get();
      return view('project.create', compact(['categories']));
    }

    public function store(Request $request) {
      $project = new Project;
      $project->name = $request->name;
      $project->description = $request->description;
      $project->start = date("Y-m-d H:i:s", strtotime($request->start));
      $project->end = date("Y-m-d H:i:s", strtotime($request->end));
      $project->category_id = $request->category_id;
      $project->status_id = 1;
      $project->save();
      $user = Auth::user()->id;
      $project->users()->sync($user);
      return redirect(route('project.index'));
    }

    public function destroy($project) {
      $project = Project::findOrFail($project);
      $project->delete();
      return redirect(route('project.index'));
    }
}
