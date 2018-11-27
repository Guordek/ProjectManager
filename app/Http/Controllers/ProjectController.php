<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Project;
use App\Category;
use App\Status;
use App\User;

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

    public function show($id) {
      $project = Auth::user()->projects->where('id', $id)->first();
      return view('project.show', compact('project'));
    }

    public function create() {
      $categories = Category::get();
      return view('project.create', compact(['categories']));
    }

    public function store(Request $request) {
      if($request->end < $request->start) {
        return redirect()->back()->withErrors('Error when creating the project. Check starting and ending date.');
      } else {
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
        return redirect(route('project.index'))->withSuccess('Project successfully stored');
      }
    }

    public function edit($id) {
      $project = Auth::user()->projects->where('id', $id)->first();
      $categories = Category::get();
      $statuses = Status::get();
      return view('project.edit', compact(['project', 'categories', 'statuses']));
    }

    public function update(Request $request, $id) {
      if($request->end < $request->start) {
        return redirect()->back()->withErrors('Error when updating the project. Check starting and ending date.');
      } else {
        $project = Auth::user()->projects->where('id', $id)->first();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->start = date("Y-m-d H:i:s", strtotime($request->start));
        $project->end = date("Y-m-d H:i:s", strtotime($request->end));
        $project->category_id = $request->category_id;
        $project->status_id = $request->status_id;
        $project->save();
        return redirect(route('project.show', $project))->withSuccess('Project successfully updated');
      }
    }

    public function formLinkUserProject($id) {
      $project = Auth::user()->projects->where('id', $id)->first();
      $usersInProject = $project->users;
      $allUsers = User::get();
      $users = $this->check_diff_multi($allUsers, $usersInProject);
      return view('project.link', compact(['project', 'users']));
    }

    public function linkUserProject(Request $request) {
      $project = Auth::user()->projects->where('id', $request->project_id)->first();
      $user = User::get()->where('id', $request->user_id)->first();
      $query = DB::table('project_user')
              ->select('project_id', 'user_id')
              ->where([
                ['project_id', $project->id],
                ['user_id', $user->id],
              ])->get();
              
      if($query->isEmpty()) {
        DB::table('project_user')->insert(
          ['project_id' => $project->id, 'user_id' => $user->id]
        );
        return redirect(route('project.show', $project))->withSuccess('User successfully added to the project');
      } else {
        return redirect()->back()->withErrors('User already exists in this project.');
      }
    }

    public function destroy($project) {
      $project = Auth::user()->projects->where('id', $project)->first();
      $project->delete();
      return redirect(route('project.index'))->withSuccess('Project successfully deleted');
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
