@extends('layouts.master')
@section('title','Show Company')
@section('companies','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
<li class="breadcrumb-item active">Show Company</li>
@endsection
@section('content')
@can('update', $company)
  <div class="row justify-content-end px-3 pb-3">
    <a href="{{ route('companies.edit',$company->id) }}" class="btn btn-warning">Edit Company</a>
  </div>
@endcan
<div class="form-group">
  <label for="name">Name</label>
  <p class="form-control">{{ $company->name }}</p>
</div>
<div class="form-group">
  <label for="name">Type</label>
  <p class="form-control">{{ ucwords($company->type) }}</p>
</div>
<label for="member">Address</label>
<table class="table table-hover" id="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($company->addresses as $data)
      <tr>
        <td>{{ $data->name }}</td>
        <td>{{ $data->address }}</td>
        <td>{{ $data->phone }}</td>
        <td>{{ $data->phone }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
