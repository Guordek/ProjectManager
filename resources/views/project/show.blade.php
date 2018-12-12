@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ $project->name }} | [{{ $project->status->name }}]</h1>
                {{ $project->start->format('d-m-Y') }} to {{ $project->end->format('d-m-Y') }}
                @if($project->created_by == Auth::user()->id)
                    <p>
                        {!! Form::open(['method' => 'get', 'url' => route('project.edit', $project->slug)]) !!}
                        {!! Form::submit('Edit the project', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </p>
                @endif
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {!! $progress !!}%;"
                         aria-valuenow="{!! $progress !!}" aria-valuemin="0" aria-valuemax="100">{!! $progress !!}%
                        complete
                    </div>
                </div>
                <br/>

                <nav class="nav nav-tabs">
                    <a class="nav-item nav-link active" href="#calendar" data-toggle="tab">Calendar</a>
                    <a class="nav-item nav-link" href="#tasks" data-toggle="tab">Tasks</a>
                    <a class="nav-item nav-link" href="#users" data-toggle="tab">Users</a>
                    <a class="nav-item nav-link" href="#files" data-toggle="tab">Files</a>
                    @if($project->created_by == Auth::user()->id)
                        <a class="nav-item nav-link" href="#owner" data-toggle="tab">Owner</a>
                    @endif
                </nav>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="calendar">
                        <br>
                        <fieldset>
                            <legend>Priority</legend>
                            @forelse($project->tasks as $task)
                                <span style="color: {!! $task->level->color !!}">{{  $task->level->name }}</span>
                            @empty
                                <span>No task recorded</span>
                            @endforelse
                            <hr>
                        </fieldset>
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                    </div>
                    <div class="tab-pane fade" id="tasks">
                        <br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Starting date</th>
                                <th scope="col">Ending date</th>
                                <th scope="col">Level</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assigned to</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($project->tasks->sortBy('end') as $task)
                                @if($date >= $task->start && $date <= $task->end)
                                    <tr class="table-warning">
                                @elseif($date > $task->end)
                                    <tr class="table-danger">
                                @elseif($date < $task->start && $date < $task->end)
                                    <tr class="table-primary">
                                @else
                                    <tr>
                                        @endif
                                        <th scope="row">{{ $task->name }}</th>
                                        <td>{{ $task->start->format('d-m-Y') }}</td>
                                        <td>{{ $task->end->format('d-m-Y') }}</td>
                                        <td>{{ $task->level->name }}</td>
                                        <td>{{ $task->status->name }}</td>
                                        @if($task->user_id == null)
                                            <td>Unassigned</td>
                                        @else
                                            <td>{{ $task->user->name }}</td>
                                        @endif
                                        <td class="column-verticallineMiddle form-inline">
                                            {!! Form::open(['method' => 'get', 'url' => route('task.show', $task->slug)]) !!}
                                            {!! Form::submit('Show', ['class' => 'btn btn-link']) !!}
                                            {!! Form::close() !!}

                                            @if($task->user_id == Auth::user()->id || $project->created_by == Auth::user()->id)
                                                {!! Form::open(['method' => 'get', 'url' => route('task.edit', $task->slug)]) !!}
                                                {!! Form::submit('Edit', ['class' => 'btn btn-link']) !!}
                                                {!! Form::close() !!}

                                                {!! Form::open(['method' => 'get', 'url' => route('task.link', $task->slug)]) !!}
                                                {!! Form::submit('Assign', ['class' => 'btn btn-link']) !!}
                                                {!! Form::close() !!}

                                                {!! Form::open(['method' => 'delete', 'url' => route('task.destroy', $task), 'onsubmit' => 'return confirmDelete()']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-link']) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No pending task</td>
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                        {!! Form::open(['method' => 'get', 'url' => route('task.createTask', $project->slug)]) !!}
                        {!! Form::submit('Add a new task', ['class' => 'btn btn-primary float-left']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="users">
                        <br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($project->users as $user)
                                <tr>
                                    <th scope="row">{{ $user->name }}</th>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($project->created_by == Auth::user()->id && $user->id != Auth::user()->id)
                                            {!! Form::open(['method' => 'delete', 'url' => route('project.removeUserFromProject', [$user->id, $project->id]), 'onsubmit' => 'return confirmDelete()']) !!}
                                            {!! Form::submit('Remove user', ['class' => 'btn btn-link']) !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No user in this project</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {!! Form::open(['method' => 'get', 'url' => route('project.formLinkUserProject', $project->slug)]) !!}
                            {!! Form::submit('Add a user to the project', ['class' => 'btn btn-primary float-left']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane fade" id="files">
                        <br>
                        <div class="form-group">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Filename</th>
                                    <th scope="col">Uploaded by</th>
                                    <th scope="col">Uploaded at</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($project->files as $file)
                                    <tr>
                                        <th scope="row">{{  $file->filename }}</th>
                                        <td>{{ $file->user->name }}</td>
                                        <td>{{ $file->created_at }}</td>
                                        <td>
                                            {{ Form::open(['method' => 'get', 'url' => route('project.dlFile', [$project->slug, $file])]) }}
                                                {!! Form::submit('Download', ['class' => 'btn btn-link']) !!}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No file uploaded</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            {!! Form::open(['method' => 'get', 'url' => route('project.addFileForm', $project->slug)]) !!}
                                {!! Form::submit('Add files', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @if($project->created_by == Auth::user()->id)
                        <div class="tab-pane fade" id="owner">
                            <br>

                            <h3>Change the owner of the project</h3>

                            {!! Form::open(['url' => route('project.changeOwnerProject', $project->id)]) !!}
                            <div class="form-group">
                                {!! Form::label('user_id', 'User') !!}
                                <select class='form-control' id='user_id' name='user_id'>
                                    @foreach($project->users as $user)
                                        <option value="{!! $user->id !!}">{!! $user->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Change owner', ['class' => 'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete ?');
        }
    </script>
@endsection
