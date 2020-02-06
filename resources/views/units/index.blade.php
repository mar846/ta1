@extends('layouts.master')
@section('title','Units')
@section('units','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Units</li>
@endsection
@section('content')
<div class="row justify-content-left px-3 pb-3">
  <a href="{{ route('units.create') }}" class="btn btn-success">Add</a>
</div>
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
  </thead>
  <tbody>
    @foreach($unit as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->name }}</td>
      <td>
        <a href="{{ route('units.show',$data->id) }}" class="btn btn-info">Info</a>
        <a href="{{ route('units.edit',$data->id) }}" class="btn btn-warning">Edit</a>
      </td>
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
