@extends('layouts.master')
@section('title','Projects Edit')
@section('order','active')
@section('project','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">Projects Edit</li>
@endsection
@section('content')
<form action="{{ route('projects.update',$project->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="inputName">Project Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$project->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputName">Project Locations</label>
        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location',$project->location) }}">
        @error('location')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputDescription">Project Description</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description',$project->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <!-- <div class="form-group">
        <label for="inputStatus">Status</label>
        <select class="form-control custom-select">
          <option selected="" disabled="">Select one</option>
          <option>On Hold</option>
          <option>Canceled</option>
          <option>Success</option>
        </select>
      </div> -->
      <div class="form-group">
        <label for="inputClientCompany">Customer</label>
        <input type="text" name="customer" class="form-control @error('customer') is-invalid @enderror" value="{{ old('customer',$project->companies->name) }}">
        @error('customer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <!-- <div class="form-group">
        <label for="inputProjectLeader">Project Leader</label>
        <input type="text" id="inputProjectLeader" class="form-control">
      </div> -->
      <div class="form-group">
        <button type="submit" class="btn btn-warning col-12" name="button">Update Project</button>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</form>
@endsection
