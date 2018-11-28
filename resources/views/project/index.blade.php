@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <h1>Your projects</h1>
          @forelse ($projects as $project)
            <div class="card">
                <div class="card-header">{{ $project->name }}</div>

                <div class="card-body">
                  <p>{{ $project->description }}</p>
                  <div class="form-group row">
                    <div class="col">
                      {!! Form::label('start', 'Starting date') !!}
                      {{ Form::text('start', $project->start, ['class' => 'form-control', 'disabled']) }}
                    </div>
                    <div class="col">
                      {!! Form::label('end', 'Ending date') !!}
                      {{ Form::text('end', $project->end, ['class' => 'form-control', 'disabled']) }}
                    </div>
                  </div>
                  {!! Form::open(['method' => 'get', 'url' => route('project.show', $project->id)]) !!}
                    {!! Form::submit('Show', ['class' => 'btn btn-primary float-left']) !!}
                  {!! Form::close() !!}
                  {!! Form::open(['method' => 'delete', 'url' => route('project.destroy', $project)]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger float-right']) !!}
                  {!! Form::close() !!}
                </div>
            </div>
            <br>
          @empty
          <div class="card">
              <div class="card-header">No project available</div>

              <div class="card-body">
                <p>Create a new one</p>
                <a href="{{ route('project.create') }}" class="btn btn-primary">Create</a>
              </div>
          </div>
          @endforelse
        </div>
        {!! Form::open(['method' => 'get', 'url' => route('project.create')]) !!}
          {!! Form::submit('Create a project', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection
