@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <h1>Link user to "{{ $project->name }}"</h1>
          <div class="form-group">
            {!! Form::label('user_id', 'User') !!}
            <select class='form-control' id='user_id' name='user_id'>
              @foreach($users as $user)
                <option value="{!! $user->id !!}">{!! $user->name !!}</option>
              @endforeach
            </select>
          </div>
      </div>
    </div>
</div>
@endsection
