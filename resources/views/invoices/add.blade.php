@extends('layouts.master')
@section('title','Make Invoice')
@section('order','active')
@section('sales','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoice</a></li>
<li class="breadcrumb-item active">Make Invoice</li>
@endsection
@section('content')
<form action="{{ route('invoices.store') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row">
    <label class="col-md-2 col-form-label">Project</label>
    <div class="col=md-10 ml-3">
      <p class="form-control">{{ $sale->projects->name }}</p>
      <input type="hidden" name="sale" value="{{ $sale->id }}">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-2 col-form-label">Sale Amount</label>
    <div class="col=md-10 ml-3">
      <p class="form-control">Rp. {{ number_format($sale->total,0,',','.') }}</p>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-2 col-form-label">Amount</label>
    <div class="col-md-10">
      <input type="number" name="amount" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-success" name="button">Make Invoice</button>
  </div>
</form>
@endsection
