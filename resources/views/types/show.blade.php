@extends('layouts.master')
@section('title','Show Type')
@section('types','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('types.index') }}">Types</a></li>
<li class="breadcrumb-item active">Show Type</li>
@endsection
@section('content')
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Name</label>
      <div class="col-sm-11 col-form-label form-control">
        {{ $type->name }}
      </div>
    </div>
  </div>
  <div class="px-3">
    <a href="{{ route('types.edit',$type->id) }}" class="btn btn-warning">Edit</a>
  </div>
@endsection
