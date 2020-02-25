@extends('layouts.master')
@section('title','List Invoice')
@section('order','active')
@section('sales','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Add Goods</li>
@endsection
@section('content')
<!-- <div class="row justify-content-between my-3">
  <div class="col-12">
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">Make Invoices</a>
  </div>
</div> -->
<table class="table table-hover">
  <thead>
    <tr>
      <th>Sale</th>
      <th>Amount</th>
      <th>Åction</th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoice as $data)
    <tr>
      <td>{{ $data->sales->projects->name }}</td>
      <td>Rp. {{ number_format($data->amount,0,',','.') }}</td>
      <td>
        <a href="{{ route('invoices.show',$data->id) }}" class="btn btn-primary">Make Invoice</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
