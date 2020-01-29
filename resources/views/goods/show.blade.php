@extends('layouts.master')
@section('title','Good Info')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Goods Info</li>
@endsection
@section('content')
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
    <label class="form-control">{{ $good->type }}</label>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-label-form">Description</label>
  <div class="col-sm-10">
    <textarea name="description" rows="8" cols="80" class="form-control">
      {{ $good->description }}
    </textarea>
  </div>
</div>
@if($good->type != 'Product')
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Supplier</label>
  <div class="col-sm-10">
    <label class="form-control"></label>
  </div>
</div>
@endif
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Storage Location</label>
  <div class="col-sm-10">
    <label class="form-control">Surabaya</label>
  </div>
</div>
@endsection
