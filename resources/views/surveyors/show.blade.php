@extends('layouts.master')
@section('title','Surveyors Info')
@section('surveyors','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('surveyors.index') }}">Surveyors</a></li>
<li class="breadcrumb-item active">Surveyors Info</li>
@endsection
@section('content')
@if(Auth::user()->role == 'SurveyorSPV')
  @if($surveyor->supervisor_id === null)
    <div class="row justify-content-left px-3 pb-3">
      <a href="{{ route('surveyorApproval',$surveyor->id) }}" class="btn btn-primary">Approve</a>
    </div>
    @else
    <div class="row justify-content-left px-3 pb-3">
      <a href="{{ route('surveyorDisapproval',$surveyor->id) }}" class="btn btn-warning">Disapprove</a>
    </div>
  @endif
@endif
@can('edit',$surveyor)
<div class="row justify-content-end">
  <div class="col-2 text-right  mb-2">
    <a href="{{ route('surveyors.edit',$surveyor->id) }}" class="btn btn-warning">Edit</a>
  </div>
</div>
@endcan
<div class="card">
  <div class="card-body">
    <div class="form-group">
      <label for="inputName">Project Name</label>
      <p class="form-control">{{ $surveyor->projects->name }}</p>
    </div>
    <label for="pt-3">Survey</label>
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
    <label class="pt-3">Files</label>
    <div class="form-group">
      @foreach($surveyor->projects->files as $data)
          <div class="card float-left mr-3" style="width: 10rem;">
            <i class="fas fa-file-image col-12 pt-3 pl-4" style="font-size: 130px;"></i>
            <div class="card-body">
              <h5 class="card-text">{{ $data->name }}</h5>
               <a href="{{ url('storage/'.$data->name) }}" class="btn btn-primary">Preview</a>
            </div>
          </div>
      @endforeach
    </div>
  </div>
  <!-- /.card-body -->
</div>
@endsection
