@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ $task->name }}</h1>
                {!! Form::open(['method' => 'put', 'url' => route('task.update', $task->slug)]) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', $task->name, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', $task->description, ['class' => 'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('level_id', 'Level') !!}
                    <select class='form-control' id='level_id' name='level_id'>
                        @foreach($levels as $level)
                            @if($level->id == $task->level_id)
                                <option value="{!! $level->id !!}" selected>{!! $level->name !!}</option>
                            @else
                                <option value="{!! $level->id !!}">{!! $level->name !!}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('status_id', 'Status') !!}
                    <select class='form-control' id='status_id' name='status_id'>
                        @foreach($statuses as $status)
                            @if($status->id == $task->status_id)
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
                        {{ Form::text('start', $task->start->format('Y-m-d'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required']) }}
                    </div>
                    <div class="col">
                        {!! Form::label('end', 'Ending date') !!}
                        {{ Form::text('end', $task->end->format('Y-m-d'), ['class' => 'form-control datepicker', 'autocomplete' => 'off', 'required']) }}
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
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1,
                minDate: new Date({{ $task->project->start->format('Y') }}, {{ $task->project->start->format('m') - 1 }}, {{ $task->project->start->format('d') }}),
                maxDate: new Date({{ $task->project->end->format('Y') }}, {{ $task->project->end->format('m') - 1 }}, {{ $task->project->end->format('d') }})
            });
        });
    </script>
@endsection
