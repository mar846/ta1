@extends('layouts.master')
@section('title','Projects Info')
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
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Project Info</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="inputName">Project Name</label>
          <p class="form-control">{{ $project->name }}</p>
        </div>
        <div class="form-group">
          <label for="inputName">Project Locations</label>
          <p class="form-control">{{ $project->location }}</p>
        </div>
        <div class="form-group">
          <label for="inputDescription">Project Description</label>
          <textarea class="form-control-plaintext border rounded" readonly>{{ $project->description }}</textarea>
        </div>
        <div class="form-group">
          <label for="inputClientCompany">Customer</label>
          <p class="form-control">{{ $project->companies->name }}</p>
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
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Sales</h3>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Number</th>
              <th>User</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($project->sales as $data)
              <tr>
                <td>SO-{{ $data->so }}</td>
                <td>{{ $data->users->name }}</td>
                <td>
                  <a href="{{ route('sales.show',$data->id) }}" class="btn btn-info text-white">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Purchases</h3>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Number</th>
              <th>User</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($project->purchases as $data)
              <tr>
                <td>PO-{{ $data->po }}</td>
                <td>{{ $data->users->name }}</td>
                <td>
                  <a href="{{ route('purchases.show',$data->id) }}" class="btn btn-info text-white">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</div>
@endsection
