@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          @include('flash::message')
          <h1>Link user to "{{ $project->name }}"</h1>
          {!! Form::open(['url' => route('project.linkUserProject', $project->id)]) !!}
            <div class="form-group">
              {!! Form::label('user_id', 'User') !!}
              <select class='form-control' id='user_id' name='user_id'>
                @foreach($users as $user)
                  <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                @endforeach
              </select>
              {{ Form::hidden('project_id', $project->id) }}
            </div>
            <div class="form-group">
              {!! Form::submit('Link', ['class' => 'btn btn-primary']) !!}
            </div>
          {!! Form::close() !!}
      </div>
    </div>
</div>
@endsection
