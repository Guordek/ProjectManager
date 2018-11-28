@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          @include('flash::message')
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">{{ $task->name }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $task->created_at }}</h6>
              <hr>
              <p class="card-text">{{ $task->description }}</p>
              <div class="card-footer text-muted">
                Assigned to {{ $task->user->name }}
              </div>
            </div>
          </div>
          <hr><hr>
          @forelse($task->comments as $comment)
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">{{ $comment->user->name }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ $comment->created_at }}</h6>
              <p class="card-text">{{ $comment->comment }}</p>
            </div>
          </div>
          <hr>
          @empty
          @endforelse

          {!! Form::open(['url' => route('comment.store')]) !!}
            <div class="form-group row">
              <div class="col">
                {!! Form::label('comment', 'Your comment') !!}
                {{ Form::textarea('comment', '', ['class' => 'form-control', 'required']) }}
                {{ Form::hidden('task_id', $task->id) }}
              </div>
            </div>
            <div class="form-group">
              {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
            </div>
          {!! Form::close() !!}
      </div>
    </div>
</div>
@endsection
