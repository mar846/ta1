@extends('layouts.master')
@section('title','Sales')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
<li class="breadcrumb-item active">Sales Info</li>
@endsection
@section('content')
{{ $sale }}
<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Sales SO-{{ $sale->so }}</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Date</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ date('D, d F Y', strtotime($sale->created_at)) }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $sale->bills->companies->name }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Bill To</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $sale->bills->address }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Ship To</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $sale->ships->address }}" disabled>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $sale->reference }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ date('D, d F Y'. strtotime('$sale->referenceDate')) }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Payment Terms</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $sale->paymentTerms }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Delivery Time</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $sale->deliveryTime }}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <table class="table table-hover table-bordered col-12" id="table">
        <thead>
          <th>Item</th>
          <th>QTY</th>
          <th>Price</th>
          <th>Subtotal</th>
        </thead>
        <tbody>
          @foreach($sale->goods as $data)
            <tr>
              <td>{{ $data->name }}</td>
              <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
              <td>IDR. {{ number_format($data->pivot->price, 2, ',', '.') }}</td>
              <td>IDR. {{ number_format($data->pivot->subtotal, 2, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-right">Total</th>
            <th>IDR. {{ number_format($sale->total, 2, ',', '.') }}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  </div>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
