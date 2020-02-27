@extends('layouts.master')
@section('title','Delivery Order')
@section('content')
<div class="">
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
    <div class="col-sm-4 invoice-col">
      Ship To
      <address>
        <strong>{{ $deliver->sales->ships->companies->name }}</strong><br>
        {{ $deliver->sales->ships->address }}<br>
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Delivery Order: DO-{{ $deliver->sales->so }}/V{{ $deliver->sales->version }}</b><br>
      <br>
      <b>Your Order ID:</b> {{ $deliver->sales->reference }}<br>
      <b>Your Order Date:</b> {{ date('D, d F Y',strtotime($deliver->sales->referenceDate)) }}<br>
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
        </tr>
        </thead>
        <tbody>
          @foreach($deliver->goods as $data)
            <tr>
              <td>{{ $data->name }}</td>
              <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
              <td>{{ $data->pivot->description }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
@endsection
