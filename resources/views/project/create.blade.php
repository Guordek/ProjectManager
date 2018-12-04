@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Create a new project</h1>
            {!! Form::open(['url' => route('project.store')]) !!}
              <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'required']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('id_category', 'Categorie') !!}
                <select class='form-control' id='category_id' name='category_id'>
                  @foreach($categories as $category)
                    <option value="{!! $category->id !!}">{!! $category->name !!}</option>
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
    $('.datepicker').datepicker({
      dateFormat: "dd-mm-yy",
      firstDay: 1
    });
  });
</script>
@endsection
