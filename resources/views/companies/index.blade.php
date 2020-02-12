@extends('layouts.master')
@section('title','Companies')
@section('companies','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Companies</li>
@endsection
@section('content')
<div class="px-3">
  <div class="row justify-content-between my-2">
    @can('create', App\Company::class)
    <a href="{{ route('companies.create') }}" class="btn btn-primary">Make Company</a>
    @endcan
  </div>
  <table class="table table-hover" id="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($company as $data)
        <tr>
          <td>{{ $data->id }}</td>
          <td>{{ $data->name }}</td>
          <td>{{ ucfirst($data->type) }}</td>
          <td>
            @can('view',$data)
            <a href="{{ route('companies.show',[$data->id]) }}" class="btn btn-info">Info</a>
            <a href="{{ route('companies.edit',[$data->id]) }}" class="btn btn-warning">Edit</a>
            @endcan
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
