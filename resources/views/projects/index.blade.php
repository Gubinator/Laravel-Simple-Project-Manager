
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::check() && Auth::user()->name)
                        {{ __('You are logged in ') }} {{ Auth::user()->name }}
                    @endif
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection



@section('projects')
        <div class="d-flex flex-column align-items-center pt-5">
            <h1>New project</h1>
            <div style="width:40%;">
                <form action="{{ url('task')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="pb-2">
                        <label for="task-name" class="controllabel">Project name</label>
                        <input type="text" name="name" id="taskname" class="form-control" value="{{ old('task') }}" required>
                    </div>
                    <div class="pb-2">
                        <label for="task-name" class="controllabel">Project description</label>
                        <input type="text" name="name" id="taskname" class="form-control" value="{{ old('task') }}" required>
                    </div>
                    <div class="pb-2">
                        <label for="task-name" class="controllabel">Project price</label>
                        <input type="number" name="name" id="taskname" class="form-control" value="{{ old('task') }}" required>
                    </div>
                    <div class="pb-2">
                        <label for="task-name" class="controllabel">Included tasks</label>
                        <input type="text" name="name" id="taskname" class="form-control" value="{{ old('task') }}" required>
                    </div>
                    <div class="pb-2">
                        <label for="task-name" class="controllabel" style="width: 8rem">Start date</label>
                        <input type="date"  />
                    </div>
                    <div class="pb-2">
                        <label for="task-name" class="controllabel" style="width: 8rem">End date</label>
                        <input type="date"  />
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6 pt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-plus"></i>Add project
                        </button>
                    </div>
                </div>
                </form>
        </div>
            <h1 class="font-weight-bold pt-5 pb-3">Projects</h1>
            <div class="container">
                @foreach ($projects as $project)
                <ul class="card list-unstyled" style="padding: 10px 10px 10px 10px">
                    <li>
                        <span><b>Name: </b>{{$project->project_name}}</span>
                    </li>
                    <li>
                        <span><b>Description: </b>{{$project->project_description}}</span>
                    </li>
                    <li>
                        <span><b>Price: </b> {{$project->project_price}} €</span>
                    </li>
                    <li>
                        <span><b>Tasks: </b>{{$project->included_tasks}}</span>
                    </li>
                    <li>
                        <span><b>Start date: </b> {{$project->start_date}}</span>
                    </li>
                    <li>
                        <span><b>End date: </b> {{$project->end_date}}</span>
                    </li>
                    <li class="pt-3">
                        <form action="{{ url('projects/'.$project->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>
                        </form>
                    </li>
                </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection


