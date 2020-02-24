@extends('layouts.master')
@section('title','Good Info')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Good Info</li>
@endsection
@section('content')
@can('update',$good)
<div class="row justify-content-end pb-3">
  <div class="px-3">
    <a href="{{ route('goods.edit',$good->id) }}" class="btn btn-warning">Edit</a>
  </div>
</div>
@endcan
<div class="form-group row">
  <label class="col-sm-1 col-form-label">Name</label>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->name }}</p>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
    <label class="col-form-label">Unit</label>
  </div>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->units->name }}</p>
    </select>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-1">
    <label class="col-form-label">Type</label>
  </div>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->types->name }}</p>
    </select>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-1 col-label-form">Description</label>
  <div class="col-sm-11">
    <textarea class="form-control">{{ $good->description }}</textarea>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-1 col-form-label">Supplier</label>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->companies->name }}</p>
  </div>
</div>
@if($good->spec != null)
<div class="form-group row">
  <label class="col-sm-1 col-label-form">Capacity</label>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->spec->capacity }}</p>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-1 col-label-form">Minimum and Maximum Voltage</label>
  <div class="form-row pl-3">
    <div class="col">
      <p class="form-control">{{ $good->spec->minVolt }}</p>
    </div>
    <div class="col">
      <p class="form-control">{{ $good->spec->maxVolt }}</p>
    </div>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-1 col-label-form">Efficiency</label>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->spec->efficiency }}</p>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-1 col-label-form">Safety Margin</label>
  <div class="col-sm-11">
    <p class="form-control">{{ $good->spec->safetyMargin }}</p>
  </div>
</div>
@endif
@endsection
