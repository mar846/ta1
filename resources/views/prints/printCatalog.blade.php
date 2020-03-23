@extends('layouts.master')
@section('title','Print Catalog')
@section('content')
<div class="p-3 mb-3">
  <!-- title row -->
  <div class="row">
    <div class="col-12">
      <h4>
        <img src="{{ asset('logo.svg') }}" alt=""> &nbsp;  &nbsp;  &nbsp; PT. Guna Elektro
      </h4>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      <address>
        <strong>PT. Guna Elektro</strong><br>
        <i class="fas fa-map-pin"></i> Jl. Rawa Gelam II No. 8 Kawasan Industri Pulo Gadung<br>
        Jakarta 14350<br>
        <i class="fas fa-phone-alt"></i> Tel : 021 4682 5450<br>
        <i class="fas fa-fax"></i> Fax : 021 4613 154
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col text-center">
      <h2>CATALOG {{ strtoupper($catalog->name) }}</h2>
      <br>
      <h4>Capacity :  {{ $catalog->capacity }}</h4>
    </div>
    <!-- /.col -->

  </div>
  <br><br>
  <div class="row">
    <div class="col-12">
      {{ $catalog->description }}
      <br>
      The following samples are only for sample-purposes. Items could be vary. For more information, don't hesitate to reach us
    </div>
  </div>
  <br><br>
  <!-- /.row -->
  <!-- Table row -->
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Product</th>
          <th>Qty</th>
        </tr>
        </thead>
        <tbody>
          @foreach($catalog->goods as $data)
            <tr>
              <td>{{ ucwords($data->name) }}</td>
              <td>{{ number_format($data->pivot->qty,0,',','.') }} {{ ucwords($data->units->name) }}</td>
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
