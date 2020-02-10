@extends('layouts.master')
@section('title','Projects')
@section('order','active')
@section('project','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Projects</li>
@endsection
@section('content')
<div class="row">
    @can('create',App\Project::class)
      <a href="{{ route('projects.create') }}" class="btn btn-success">Add</a>
    @endcan
</div>
<div class="row">
  <div class="col-12">
    {{ $project }}
    <table class="table table-hover" id="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Client</th>
          <th>Location</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($project as $data)
          <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->companies->name }}</td>
            <td>{{ $data->location }}</td>
            <td>{{ $data->description }}</td>
            <td>
              <a href="{{ route('projects.show',$data->id) }}" class="btn btn-secondary">Info</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
@section('script')
@endsection
