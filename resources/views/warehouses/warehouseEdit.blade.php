@extends('layouts.app')
@section('title','Edit Warehouse')
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="container">
  <h3>Edit Warehouse</h3>
  <form action="{{ route('warehouses.update',[$warehouse->id]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" placeholder="pce, pcs, unit, kg, g,....." name="name" value="{{ $warehouse->name }}" autofocus>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Location</label>
      <div class="col-sm-10">
        <textarea name="location" class="form-control" rows="8" cols="80">{{ $warehouse->location }}</textarea>
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
