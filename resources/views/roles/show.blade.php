@extends('layouts.master')
@section('roles','active')
@section('title','Role Info')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
<li class="breadcrumb-item active">Role Info</li>
@endsection
@section('content')
  @can('update', $role)
    <div class="row justify-content-end px-3 pb-3">
      <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-warning">Edit Role</a>
    </div>
  @endcan
  <div class="form-group">
    <label for="name">Name</label>
    <p class="form-control">{{ $role->name }}</p>
  </div>
  <label for="member">Users</label>
  <table class="table table-hover" id="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
      </tr>
    </thead>
    <tbody>
      @foreach($role->users as $data)
        <tr>
          <td>{{ $data->id }}</td>
          <td>{{ $data->name }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
@section('script')
@endsection
