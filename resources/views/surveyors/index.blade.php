@extends('layouts.master')
@section('title','Surveyors')
@section('surveyors','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Surveyors</li>
@endsection
@section('content')
@can('create',App\Surveyor::class)
<div class="row justify-content-left px-3 pb-3">
  <a href="{{ route('surveyors.create') }}" class="btn btn-primary">Make Survey</a>
</div>
@endcan
<table class="table table-hover" id="table">
  <thead>
    <th>ID</th>
    <th>Project</th>
    <th>Location</th>
    <th>Status</th>
    <th>Action</th>
  </thead>
  <tbody>
    @foreach($surveyor as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->projects->name }}</td>
      <td>{{ $data->projects->location }}</td>
      <td class="{{ ($data->supervisor_id == null)?'alert alert-secondary':'alert alert-success' }} text-center pt-3"><label for="status">{{ ($data->supervisor_id == null)?'Waiting':'Approved' }}</label></td>
      <td>
        @can('viewAny',App\Surveyor::class)
        <a href="{{ route('surveyors.show',$data->id) }}" class="btn btn-info">Info</a>
        @endcan
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
