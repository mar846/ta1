@extends('layouts.master')
@section('title','Edit Good')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Edit Good</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
{{ $good }}
<form action="{{ route('goods.update',[$good->id]) }}" method="post">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="pce, pcs, unit, kg, g,....." name="name" value="{{ old('name',$good->name) }}">
      @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">
      <label class="col-form-label">QTY</label>
    </div>
    <div class="col-sm-2">
      <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty" placeholder="50" value="{{ old('qty', $good->qty) }}">
      @error('qty')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
    <div class="col-sm-2">
      <select class="form-control" name="unit">
        <option>Select Unit</option>
        @foreach($unit as $data)
        <option value="{{ $data->id }}" @if($data->id == $good->unit_id) selected @endif>{{ $data->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Type</label>
    <div class="col-sm-10">
      <select class="form-control" name="type">
        <option value="panel" selected>{{ $good->type }}</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" name="price" value="{{ old('price',$good->price) }}">
    </div>
  </div>
  <!--
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Storage Location</label>
    <div class="col-sm-10">
      <select class="form-control" name="warehouse">
        <option value="">Select Warehouse</option>

      </select>
    </div>
  </div> -->
  <div class="form-group row">
    <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
  </div>
</form>
@endsection
