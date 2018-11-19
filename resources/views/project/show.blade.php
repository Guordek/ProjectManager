@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <h1>{{ $project->name }}</h1>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Description</th>
                  <th scope="col">Starting date</th>
                  <th scope="col">Ending date</th>
                  <th scope="col">Level</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($project->tasks as $task)
                <tr>
                  <th scope="row">{{ $task->name }}</th>
                  <td>{{ $task->description }}</td>
                  <td>{{ $task->start }}</td>
                  <td>{{ $task->end }}</td>
                  <td>{{ $task->level->name }}</td>
                  <td>
                    {!! Form::open(['method' => 'delete', 'url' => route('task.destroy', $task)]) !!}
                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6">No pending task</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            {!! Form::open(['method' => 'get', 'url' => route('task.createTask', $project->id)]) !!}
              {!! Form::submit('Add a new task', ['class' => 'btn btn-primary float-left']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
