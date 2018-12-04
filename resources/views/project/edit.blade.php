@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create a new project</h1>
            {!! Form::open(['method' => 'put', 'url' => route('project.update', $project->id)]) !!}
              <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', $project->name, ['class' => 'form-control', 'required']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description', $project->description, ['class' => 'form-control', 'required']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('category_id', 'Categorie') !!}
                <select class='form-control' id='category_id' name='category_id'>
                  @foreach($categories as $category)
                    @if($category->id == $project->category_id)
                      <option value="{!! $category->id !!}" selected>{!! $category->name !!}</option>
                    @else
                      <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                {!! Form::label('status_id', 'Status') !!}
                <select class='form-control' id='status_id' name='status_id'>
                  @foreach($statuses as $status)
                    @if($status->id == $project->status_id)
                      <option value="{!! $status->id !!}" selected>{!! $status->name !!}</option>
                    @else
                      <option value="{!! $status->id !!}">{!! $status->name !!}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group row">
                <div class="col">
                  {!! Form::label('start', 'Starting date') !!}
                  {{ Form::text('start', $project->start->format('Y-m-d'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required']) }}
                </div>
                <div class="col">
                  {!! Form::label('end', 'Ending date') !!}
                  {{ Form::text('end', $project->end->format('Y-m-d'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required']) }}
                </div>
              </div>
              <div class="form-group">
                {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
              </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
  $(function() {
    $(".datepicker").datepicker({
      dateFormat: "yy-mm-dd"
    });
  });
  </script>
@endsection
