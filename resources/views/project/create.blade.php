@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Create a new project</h1>
            {!! Form::open(['url' => route('project.store')]) !!}
              <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::text('description', null, ['class' => 'form-control']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('id_category', 'Categorie') !!}
                <select class='form-control' id='category_id' name='category_id'>
                  @foreach($categories as $category)
                    <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                {!! Form::label('start', 'Starting date') !!}
                {{ Form::text('start', '', ['class' => 'form-control datepicker']) }}
              </div>
              <div class="form-group">
                {!! Form::label('end', 'Ending date') !!}
                {{ Form::text('end', '', ['class' => 'form-control datepicker']) }}
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
    $(".datepicker").datepicker();
  });
  </script>
@endsection
