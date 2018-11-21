@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <h1>Link user to "{{ $task->name }}"</h1>
          {!! Form::open(['url' => route('task.linkUserTask', $task)]) !!}
            <div class="form-group">
              {!! Form::label('user_id', 'User') !!}
              <select class='form-control' id='user_id' name='user_id'>
                @foreach($users as $user)
                  <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              {!! Form::submit('Link', ['class' => 'btn btn-primary']) !!}
            </div>
          {!! Form::close() !!}
      </div>
    </div>
</div>
@endsection
