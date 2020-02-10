@extends('layouts.master')
@section('title','Purchase Edit')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Purchase Edit</li>
@endsection
@section('content')
<form action="{{ route('purchases.update',$purchase->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
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
              <input type="text" class="form-control" name="created_at" value="{{ date('Y-m-d', strtotime($purchase->created_at)) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Supplier</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="supplier"  value="{{ $purchase->addresses->companies->name }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="address"  value="{{ $purchase->addresses->address }}">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Reference</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="reference"  value="{{ $purchase->reference }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Reference Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="referenceDate"  value="{{ date('Y-m-d'. strtotime('$purchase->referenceDate')) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Payment Terms</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="paymentTerms"  value="{{ $purchase->paymentTerms }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Delivery Time</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="deliveryTime"  value="{{ $purchase->deliveryTime }}">
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
      <div class="row">
        <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
      </div>
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
