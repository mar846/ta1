@extends('layouts.master')
@section('title','Surveyors Info')
@section('surveyors','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('surveyors.index') }}">Surveyors</a></li>
<li class="breadcrumb-item active">Surveyors Info</li>
@endsection
@section('content')
<div class="row justify-content-end">
  <div class="col-2 text-right  mb-2">
    <a href="{{ route('surveyors.edit',$surveyor->id) }}" class="btn btn-warning">Edit</a>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <div class="form-group">
      <label for="inputName">Project Name</label>
      <p class="form-control">{{ $surveyor->projects->name }}</p>
    </div>
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Question</th>
          <th>Answer</th>
        </tr>
      </thead>
      <tbody>
        @foreach($surveyor->checklists as $data)
          <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->question }}</td>
            <td>{{ $data->pivot->answer }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
@endsection
