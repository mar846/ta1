@extends('layouts.master')
@section('title',"Good's Type")
@section('types','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Good's Type</li>
@endsection
@section('content')
<div class="row justify-content-left px-3 pb-3">
  <a href="{{ route('types.create') }}" class="btn btn-primary">Add Type</a>
</div>
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
  </thead>
  <tbody>
    @foreach($type as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->name }}</td>
      <td>
        <a href="{{ route('types.show',$data->id) }}" class="btn btn-info">Info</a>
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
