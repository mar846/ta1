@extends('layouts.master')
@section('title','Edit Company')
@section('companies','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
<li class="breadcrumb-item active">Edit Company</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="px-3">
  <form action="{{ route('companies.update',[$company->id]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" value="{{ $company->name }}">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Address</label>
      <div class="col-sm-10">
        <textarea name="address" class="form-control" rows="8" cols="80">{{ $company->address }}</textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Phone</label>
      <div class="col-sm-10">
        <input type="text" name="phone" class="form-control" value="{{ $company->phone }}">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-12 text-right">
        <button type="submit" class="btn btn-success" name="button">Update</button>
      </div>
    </div>
  </form>
</div>
@endsection
