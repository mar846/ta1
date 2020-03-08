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
@can('approve',App\Sale::class)
  @if($sale->supervisor_id == null)
  <div class="row justify-content-start">
    <div class="col-2 text-left mb-2">
      <a href="{{ route('saleApproval',$sale->id) }}" class="btn btn-primary">Approve</a>
    </div>
  </div>
  @else
  <div class="row justify-content-start">
    <div class="col-2 text-left mb-2">
      <a href="{{ route('saleDisapproval',$sale->id) }}" class="btn btn-warning">Disapprove</a>
    </div>
  </div>
  @endif
@endcan
@if($sale->user_id == Auth::user()->id)
<div class="row justify-content-end">
  <div class="col-2 text-right  mb-2">
    @if($sale->supervisor_id != null)
    <a href="{{ route('makeSaleInvoice',$sale->id) }}" class="btn btn-primary">Make Invoice</a>
    @endif
    <!-- @if($sale->supervisor_id != null)
    <a href="{{ route('delivers.show',$sale->id) }}" class="btn btn-info">Make Delivery Order</a>
    @endif -->
    @if($sale->supervisor_id == null)
    <a href="{{ route('sales.edit',$sale->id) }}" class="btn btn-warning">Edit</a>
    @endif
  </div>
</div>
@endif
<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">Sales SO-{{ $sale->so }}/V{{ $sale->version }}</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Date</label>
          <div class="col-sm-10">
            <p class="form-control">{{ date('D, d F Y', strtotime($sale->created_at)) }} </p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-sm-10">
            <p class="form-control">{{ $sale->bills->companies->name }} </p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Bill To</label>
          <div class="col-sm-10">
            <p class="form-control">{{ $sale->bills->address }} </p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Ship To</label>
          <div class="col-sm-10">
            <p class="form-control">{{ $sale->ships->address }} </p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <p class="form-control">{{ $sale->reference }} </p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <p class="form-control">{{ date('D, d F Y'. strtotime('$sale->referenceDate')) }} </p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Payment Terms</label>
          <div class="col-sm-10">
            @foreach($sale->terms as $data)
              <p class="form-control">{{ $data->percentage }}% {{ $data->description }}</p>
            @endforeach
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Delivery Time</label>
          <div class="col-sm-10">
            <p class="form-control">{{ $sale->deliveryTime }} </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <table class="table table-hover">
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
