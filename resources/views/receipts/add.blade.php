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
  <label class="col-sm-2 col-form-label">Purchase Order</label>
  <div class="col-sm-10">
    <p class="form-control">{{ $purchase->po }}/V{{ $purchase->version }}</p>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Supplier</label>
  <div class="col-sm-10">
    <p class="form-control">{{ $purchase->addresses->companies->name }}</p>
  </div>
</div>
<form action="{{ route('receipts.store') }}" method="post">
  {{ csrf_field() }}
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>Qty</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $array = [];
        foreach ($purchase->receipts as $datas) {
          foreach ($datas->goods as $datass) {
            if (isset($array[$datass['id']])) {
              $array[$datass['id']] += $datass->pivot->qty;
            }
            else {
              $array[$datass['id']] = $datass->pivot->qty;
            }
          }
        }
      ?>
      @foreach($purchase->goods as $key => $data)
        <tr>
          <td>{{ $data->name }}</td>
          <td>
            @if(isset($array[$data->id]))
              @if($array[$data->id] < $data->pivot->qty)
                <input type="number" name="qty{{ $key }}" class="form-control @error('qty.$key') is-invalid @enderror" max="{{ $data->pivot->qty - $array[$data->id] }}">
              @endif
            @else
              <input type="number" name="qty{{ $key }}" class="form-control @error('qty.$key') is-invalid @enderror" max="{{ $data->pivot->qty }}">
            @endif
            @error('qty.$key')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <hr>
  <div class="form-group row">
    <input type="hidden" name="purchase" value="{{ $purchase->id }}">
    <button type="submit" class="btn btn-success col-12" name="button">Make Receipt</button>
  </div>
</form>
@endsection
