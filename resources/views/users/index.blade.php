@extends('layouts.master')
@section('title','Users')
@section('users','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Users</li>
@endsection
@section('content')
<div class="row justify-content-left px-3 pb-3">
  <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
</div>
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Name</th>
    <th>Role</th>
    <!-- <th>Action</th> -->
  </thead>
  <tbody>
    @foreach($user as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->name }}</td>
      <td>{{ $data->roles->name }}</td>
      <!-- <td>
        <a href="{{ route('users.show',$data->id) }}" class="btn btn-info">Info</a>
      </td> -->
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#table').DataTable();
  });
</script>
@endsection
