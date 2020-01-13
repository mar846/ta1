@extends('layouts.app')
@section('title','Good Info')
@section('content')
<div class="container">
  <h3>Good Show</h3>
  <div class="form-group row my-3">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <label class="form-control">{{ $good->name }}</label>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">QTY</label>
    <div class="col-sm-10">
      <label class="form-control">{{ $good->qty }} {{ $good->units->name }}</label>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-label-form">Category</label>
    <div class="col-sm-10">
      <label class="form-control">
        @foreach($good->categories as $data)
          {{ $data->name }}
        @endforeach
      </label>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-label-form">Description</label>
    <div class="col-sm-10">
      <textarea name="description" rows="8" cols="80" class="form-control">
        @foreach($good->categories as $data)
         {{ $data->pivot->description }}
        @endforeach
      </textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Supplier</label>
    <div class="col-sm-10">
      <label class="form-control">{{ $good->companies->name }}</label>
    </div>

  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Storage Location</label>
    <div class="col-sm-10">
      <label class="form-control">{{ $good->warehouses->name }}</label>
    </div>
  </div>
</div>
@endsection
