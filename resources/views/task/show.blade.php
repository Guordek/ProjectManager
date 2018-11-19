@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <h1>{{ $task->name }}</h1>
          <textarea class="form-control" rows="5" disabled>{{ $task->description }}</textarea>
      </div>
    </div>
</div>
@endsection
