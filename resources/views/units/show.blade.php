@extends('layouts.master')
@section('title','Show Unit')
@section('units','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a></li>
<li class="breadcrumb-item active">Show Unit</li>
@endsection
@section('content')
<!-- form start -->
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Name</label>
      <div class="col-sm-11 col-form-label">
        {{ $unit->name }}
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="px-3">
    <a href="{{ route('units.edit',$unit->id) }}" class="btn btn-warning">Edit</a>
  </div>
  <!-- /.card-footer -->
@endsection
