@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <h1>{{ $project->name }} | [{{ $project->status->name }}]</h1>
            <p>
              {!! Form::open(['method' => 'get', 'url' => route('project.edit', $project)]) !!}
                {!! Form::submit('Edit the project', ['class' => 'btn btn-primary']) !!}
              {!! Form::close() !!}
            </p>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Description</th>
                  <th scope="col">Starting date</th>
                  <th scope="col">Ending date</th>
                  <th scope="col">Level</th>
                  <th scope="col">Assigned to</th>
                  <th scope="col">Actions</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                @forelse($project->tasks->sortBy('end') as $task)
                <tr>
                  <th scope="row">{{ $task->name }}</th>
                  <td>{{ $task->description }}</td>
                  <td>{{ $task->start }}</td>
                  <td>{{ $task->end }}</td>
                  <td>{{ $task->level->name }}</td>
                  <td>{{ $task->user->name }}</td>
                  <td>
                    {!! Form::open(['method' => 'get', 'url' => route('task.show', $task)]) !!}
                      {!! Form::submit('Show', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                  </td>
                  <td>
                    {!! Form::open(['method' => 'delete', 'url' => route('task.destroy', $task)]) !!}
                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8">No pending task</td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="8">
                    {!! Form::open(['method' => 'get', 'url' => route('task.createTask', $project->id)]) !!}
                      {!! Form::submit('Add a new task', ['class' => 'btn btn-primary float-left']) !!}
                    {!! Form::close() !!}
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <div class="col-md-12">
            <h3>Users on this project</h3>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($project->users as $user)
                <tr>
                  <th scope="row">{{ $user->name }}</th>
                  <td>{{ $user->email }}</td>
                  <td>

                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4">No user in this project</td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="7">
                    {!! Form::open(['method' => 'get', 'url' => route('project.formLinkUserProject', $project->id)]) !!}
                      {!! Form::submit('Add a user to the project', ['class' => 'btn btn-primary float-left']) !!}
                    {!! Form::close() !!}
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
