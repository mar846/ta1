@extends('layouts.master')
@section('title','Delivery')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Deliver</a></li>
<li class="breadcrumb-item active">Make Delivery</li>
@endsection
@section('content')
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Sales Order</label>
  <div class="col-sm-10">
    <p class="form-control">SO-{{ $sale->so }}/V{{ $sale->version }}</p>
  </div>
</div>
<form action="{{ route('delivers.store') }}" method="post">
  {{ csrf_field() }}
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>Qty</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sale->goods as $key => $data)
        <tr>
          <td>{{ $data->name }}</td>
          <td><input type="number" name="qty{{ $key }}" class="form-control" max="{{ $data->pivot->qty }}"></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <hr>
  <div class="form-group row">
    <input type="hidden" name="sale" value="{{ $sale->id }}">
    <button type="submit" class="btn btn-success col-12" name="button">Make Delivery</button>
  </div>
</form>
@endsection
