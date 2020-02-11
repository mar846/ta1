@extends('layouts.master')
@section('title','Designers')
@section('designers','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Designers</li>
@endsection
@section('content')
<div class="row justify-content-left px-3 pb-3">
  <a href="{{ route('designers.create') }}" class="btn btn-success">Add</a>
</div>
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Project</th>
    <th>Location</th>
    <th>Action</th>
  </thead>
  <tbody>
    @foreach($designer as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->projects->name }}</td>
        <td>{{ $data->projects->location }}</td>
        <td>
          <a href="{{ route('designers.show',1) }}" class="btn btn-info">Info</a>
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
