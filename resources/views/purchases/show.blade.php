@extends('layouts.master')
@section('title','Purchase Info')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Purchase Info</li>
@endsection
@section('content')
<div class="row justify-content-end">
  <div class="col-2 text-right  mb-2">
    @can('view',$purchase)
      <a href="{{ route('makePurchaseInvoice',$purchase->id) }}" class="btn btn-primary">Make Invoice</a>
    @endcan
    @can('update',$purchase)
      <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning">Edit</a>
    @endcan
  </div>
</div>
<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Purchase PO-{{ $purchase->po }}</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Date</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ date('D, d F Y', strtotime($purchase->created_at)) }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $purchase->addresses->companies->name }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $purchase->addresses->address }}" disabled>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $purchase->reference }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ date('D, d F Y'. strtotime('$purchase->referenceDate')) }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Payment Terms</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $purchase->paymentTerms }}" disabled>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Delivery Time</label>
          <div class="col-sm-10">
            <input type="text" class="form-control-plaintext border rounded pl-3" value="{{ $purchase->deliveryTime }}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <table class="table table-hover col-12">
        <thead>
          <th>Item</th>
          <th>QTY</th>
          <th>Price</th>
          <th>Subtotal</th>
        </thead>
        <tbody>
          @foreach($purchase->goods as $data)
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
            <th>IDR. {{ number_format($purchase->total, 2, ',', '.') }}</th>
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
