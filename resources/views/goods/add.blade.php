@extends('layouts.master')
@section('title','Add Good')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Add Goods</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<form action="{{ route('goods.store') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row my-3">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" placeholder="Solar Panel, Inverter, Sun Logger" name="name" value="{{ old('name') }}">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">
      <label class="col-form-label">QTY</label>
    </div>
    <div class="col-sm-2">
      <input type="text" class="form-control" name="qty" placeholder="50" value="{{ old('qty') }}">
    </div>
    <div class="col-sm-2">
      <input type="text" class="form-control" name="unit" placeholder="pce, pcs">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-label-form">Description</label>
    <div class="col-sm-10">
      <textarea name="description" rows="8" cols="80" class="form-control">{{ old('description') }}</textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Supplier</label>
    <div class="col-sm-10">
      <input type="text" name="company" class="form-control" list="dataCompany">
      <!-- <select class="form-control" name="company">
        <option value="">Select Supplier</option>
        @foreach($company as $data)
          <option value="{{ $data->id }}">{{ $data->name }}</option>
        @endforeach
      </select> -->
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Storage Location</label>
    <div class="col-sm-10">
      <input type="text" name="warehouse" class="form-control" list="dataWarehouse">
      <!-- <select class="form-control" name="warehouse">
        <option value="">Select Warehouse</option>
        @foreach($warehouse as $data)
          <option value="{{ $data->id }}">{{ $data->name }}</option>
        @endforeach
      </select> -->
    </div>
  </div>
  <div class="form-group row">
    <button type="submit" class="btn btn-success col-12" name="button">Add</button>
  </div>
</form>
<datalist id="dataCompany">
  @foreach($company as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
<datalist id="dataWarehouse">
  @foreach($warehouse as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
@endsection
