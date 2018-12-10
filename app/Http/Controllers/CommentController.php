<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Comment;
use App\Task;

class CommentController extends Controller
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
    public function store(Request $request)
    {
        $task = Task::get()->where('id', $request->task_id)->first();
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->task_id = $request->task_id;
        $comment->user_id = $user = Auth::user()->id;
        $comment->save();
        return redirect(route('task.show', $task->slug));
    }
}
