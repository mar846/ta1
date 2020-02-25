@extends('layouts.master')
@section('roles','active')
@section('title','Roles')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Roles</li>
@endsection
@section('content')
  @can('create', App\Role::class)
    <div class="row justify-content-left px-3 pb-3">
      <a href="{{ route('roles.create') }}" class="btn btn-primary">Add Role</a>
    </div>
  @endcan
  <table class="table table-hover" id="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($role as $data)
        <tr>
          <td>{{ $data->id }}</td>
          <td>{{ $data->name }}</td>
          <td>
            <a href="{{ route('roles.show',$data->id) }}" class="btn btn-info">Info</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
