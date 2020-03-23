@extends('layouts.master')
@section('title','Purchase Order')
@section('content')
<div class="p-3 mb-3">
  <!-- title row -->
  <div class="row">
    <div class="col-12">
      <h4>
        <img src="{{ asset('logo.svg') }}" alt=""> PT. Guna Elektro
      </h4>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      From
      <address>
        <strong>PT. Guna Elektro</strong><br>
        <i class="fas fa-map-pin"></i> Jl. Rawa Gelam II No. 8 Kawasan Industri Pulo Gadung<br>
        Jakarta 14350<br>
        <i class="fas fa-phone-alt"></i> Tel : 021 4682 5450<br>
        <i class="fas fa-fax"></i> Fax : 021 4613 154
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      To
      <address>
        <strong>{{ $purchase->addresses->companies->name }}</strong><br>
        {{ $purchase->addresses->address }}<br>
        Phone: {{ $purchase->addresses->phone }}<br>
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Invoice: {{ $purchase->po }}</b><br>
      <br>
      <b>Order ID:</b> {{ $purchase->reference }}<br>
      <!-- <b>Payment Due:</b> 2/22/2014<br>
      <b>Account:</b> 968-34567 -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- Table row -->
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>Description</th>
          <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
          @foreach($purchase->goods as $data)
            <tr>
              <td>{{ $data->name }}</td>
              <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
              <td>{{ $data->pivot->description }}</td>
              <td>IDR. {{ number_format($data->pivot->subtotal, 2, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->
    <div class="col-6">
      <p class="lead">Payment Methods :</p>
      <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
        {{ $purchase->paymentTerms }}
      </p>
      <p class="lead">Delivery Time :</p>
      <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
        {{ $purchase->deliveryTime }}
      </p>
    </div>
    <!-- /.col -->
    <div class="col-6">

      <div class="table-responsive">
        <table class="table">
          <tbody><tr>
            <th style="width:50%">Subtotal:</th>
            <td>IDR. {{ number_format($purchase->total, 2, ',', '.') }}</td>
          </tr>
          <tr>
            <th>Tax (10%)</th>
            <td>IDR. {{ number_format(($purchase->total * 0.1), 2, ',', '.') }}</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td>IDR. {{ number_format(($purchase->total * 1.1), 2, ',', '.') }}</td>
          </tr>
        </tbody></table>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- this row will not appear when printing -->
  <!-- <div class="row no-print">
    <div class="col-12">
      <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
      <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
        Payment
      </button>
      <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
        <i class="fas fa-download"></i> Generate PDF
      </button>
    </div>
  </div> -->
</div>
@endsection
