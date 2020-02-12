@extends('layouts.master')
@section('title','Surveyors')
@section('surveyors','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Surveyors</li>
@endsection
@section('content')
<div class="row justify-content-left px-3 pb-3">
  <a href="{{ route('surveyors.create') }}" class="btn btn-primary">Make Survey</a>
</div>
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Project</th>
    <th>Location</th>
    <th>Action</th>
  </thead>
  <tbody>
    @foreach($surveyor as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->projects->name }}</td>
      <td>{{ $data->projects->location }}</td>
      <td>
        <a href="{{ route('surveyors.show',$data->id) }}" class="btn btn-info">Info</a>
        <a href="{{ route('surveyors.edit',$data->id) }}" class="btn btn-warning">Edit</a>
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
