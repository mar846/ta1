@extends('layouts.master')
@section('title','Projects Info')
@section('order','active')
@section('project','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">Projects Info</li>
@endsection
@section('content')
<div class="row justify-content-end">
  <div class="col-2 text-right  mb-2">
    <a href="{{ route('projects.edit',$project->id) }}" class="btn btn-warning">Edit</a>
  </div>
</div>
</div>
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="inputName">Project Name</label>
        <input type="text" name="name" class="form-control" value="{{ $project->name }}">
      </div>
      <div class="form-group">
        <label for="inputName">Project Locations</label>
        <input type="text" name="location" class="form-control" value="{{ $project->location }}">
      </div>
      <div class="form-group">
        <label for="inputDescription">Project Description</label>
        <textarea name="description" class="form-control" rows="4">{{ $project->description }}</textarea>
      </div>
      <div class="form-group">
        <label for="inputClientCompany">Customer</label>
        <input type="text" name="customer" class="form-control" value="{{ $project->companies->name }}">
      </div>
      <label>Files</label>
      <div class="form-group">
        @foreach($project->files as $data)
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
