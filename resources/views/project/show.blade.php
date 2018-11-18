@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <h1>{{ $project->name }}</h1>
            <p>{{ $project->description }}</p>
            @forelse($project->tasks as $task)
            <p>{{ $task->name }}</p>
            <p>{{ $task->description }}</p>
            @empty
            <p>No task pending</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
