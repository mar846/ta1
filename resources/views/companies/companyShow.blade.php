@extends('layouts.app')
@section('title','Show Company')
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="">
  <div class="row justify-content-between mx-1 my-2">
    <h3>Show Company</h3>
    <a href="{{ route('companies.edit',[$company->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Name</label>
    <label>{{ $company->name }}</label>
  </div>
  @foreach($company->addresses as $data)
  <div class="card my-3">
    <h5 class="card-header">{{ $data->name }}</h5>
    <div class="card-body">
      <h6 class="card-subtitle mb-2 text-muted">{{ $data->phone }}</h6>
      <p class="card-text">{{ $data->address }}</p>
      <a href="{{ route('addresses.edit',$data->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
  @endforeach
</div>
@endsection
