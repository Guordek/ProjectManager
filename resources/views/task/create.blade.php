@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <h1>{{ $project->name }}</h1>
          {!! Form::open(['url' => route('task.store')]) !!}
            <div class="form-group">
              {!! Form::label('name', 'Name') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('description', 'Description') !!}
              {!! Form::textarea('description', null, ['class' => 'form-control', 'required']) !!}
            </div>
          <div class="form-group">
            {!! Form::label('level_id', 'Level') !!}
            <select class='form-control' id='level_id' name='level_id'>
              @foreach($levels as $level)
                <option value="{!! $level->id !!}">{!! $level->name !!}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group row">
            <div class="col">
              {!! Form::label('start', 'Starting date') !!}
              {{ Form::text('start', '', ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required']) }}
            </div>
            <div class="col">
              {!! Form::label('end', 'Ending date') !!}
              {{ Form::text('end', '', ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required']) }}
            </div>
          </div>
            {{ Form::hidden('project_id', $project->id) }}
          <div class="form-group">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
          </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
  $(function() {
    $('.datepicker').datepicker();
  });
</script>
@endsection
