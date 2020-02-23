@extends('layouts.master')
@section('title','Criterias')
@section('criteria','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Criteria</li>
@endsection
@section('content')
<!-- <div class="row justify-content-left px-3 pb-3"> -->
  <!-- <a href="{{ route('criterias.create') }}" class="btn btn-primary">Add Criteria</a> -->
<!-- </div> -->
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Name</th>
    <th>Weight</th>
    <th>Action</th>
  </thead>
  <tbody>
    @foreach($criteria as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->name }}</td>
      <td>{{ $data->weight }}</td>
      <td>
        <a href="{{ route('criterias.edit',$data->id) }}" class="btn btn-warning">Edit</a>
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
