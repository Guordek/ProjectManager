@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @forelse ($projects as $project)
            <div class="card">
                <div class="card-header">{{ $project->name }}</div>

                <div class="card-body">
                  
                </div>
            </div>
          @empty
          <div class="card">
              <div class="card-header">No project available</div>

              <div class="card-body">
                Create a new one
              </div>
          </div>
          @endforelse
        </div>
    </div>
</div>
@endsection
