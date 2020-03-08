@extends('layouts.master')
@section('title','Make Invoice')
@section('order','active')
@section('sales','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoice</a></li>
<li class="breadcrumb-item active">Make Invoice</li>
@endsection
@section('content')
  <div class="form-group row">
    <label class="col-md-3 col-form-label">Project</label>
    <div class="col=md-9 ml-3">
      <p class="form-control">{{ $sale->projects->name }}</p>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-3 col-form-label">Sale Amount</label>
    <div class="col=md-9 ml-3">
      <p class="form-control">Rp. {{ number_format($sale->total,0,',','.') }}</p>
    </div>
  </div>
  <label>Terms</label>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Percentage</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sale->terms as $data)
      <tr>
        <td>{{ $data->percentage }}%</td>
        <td>{{ $data->description }}</td>
        <td>
        <form action="{{ route('invoices.store') }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="sale" value="{{ $sale->id }}">
          <input type="hidden" name="amount" value="{{ ($sale->total*($data->percentage/100)) }}">
          <button type="submit" class="btn btn-success" name="button">Make Invoice</button>
        </form>
        </td>
      </tr>
      @endforeach
      <tr>
        <td></td>
      </tr>
    </tbody>
  </table>
  <!-- <div class="form-group row">
    <label class="col-md-3 col-form-label">Amount</label>
    <div class="col-md-9">
      @foreach($sale->terms as $data)
      <p class="form-control">{{ $data->percentage }}% {{ $data->description }}</p> <button type="button" class="btn btn-success" name="button">Make Invoice</button>
      @endforeach
    </div>
  </div> -->
  <!-- <div class="form-group">
    <button type="submit" class="btn btn-success" name="button">Make Invoice</button>
  </div> -->
@endsection
