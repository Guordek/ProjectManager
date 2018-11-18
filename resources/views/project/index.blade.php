@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          <h1>Your projects</h1>
          @forelse ($projects as $project)
            <div class="card">
                <div class="card-header">{{ $project->name }}</div>

                <div class="card-body">
                  <p>{{ $project->description }}</p>
                  {!! Form::open(['method' => 'delete', 'url' => route('project.destroy', $project)]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger float-right']) !!}
                  {!! Form::close() !!}
                </div>
            </div>
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
    </div>
</div>
@endsection
