@extends('layouts.master')
@section('title','Sales')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
<li class="breadcrumb-item active">Sales Edit</li>
@endsection
@section('content')
{{ $sale }}
<form action="{{ route('sales.update',$sale->id) }}" method="post">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
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
              <input type="text" class="form-control-plaintext border rounded pl-3" name="created_at" value="{{ old('created_at',date('Y-m-d', strtotime($sale->created_at))) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Customer</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="customer" value="{{ old('customer',$sale->bills->companies->name) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Bill To</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="billTo" value="{{ old('billTo',$sale->bills->address) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Ship To</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="shipTo" value="{{ old('shipTo',$sale->ships->address) }}">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Reference</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="reference" value="{{ old('reference',$sale->reference) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Reference Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="referenceDate" value="{{ old('referenceDate',$sale->referenceDate) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Payment Terms</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="paymentTerms" value="{{ old('paymentTerms',$sale->paymentTerms) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Delivery Time</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="deliveryTime" value="{{ old('deliveryTime',$sale->deliveryTime) }}">
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
      <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
    </div>
  </div>
</form>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
