@extends('layouts.master')
@section('title','Purchases')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Purchases</li>
@endsection
@section('content')
<div class="m-3">
  <div class="row justify-content-between px-3 pb-2">
    @can('create',App\Sale::class)
      <a href="{{ route('purchases.create') }}" class="btn btn-primary">Make Quotation</a>
    @endcan
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Date</th>
      <th>Supplier</th>
      <th>Purchase Order</th>
      <th>Action</th>
    </tr>
    @foreach($purchase as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ date('D, d F Y', strtotime($data->created_at)) }}</td>
        <td>{{ $data->addresses->companies->name }}</td>
        <td>{{ $data->po }}</td>
        <td>
          @can('view',$data)
          <a href="{{ route('purchases.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          @endcan
          <!-- <a href="{{ route('purchases.edit',[$data->id]) }}"><button type="button" class="btn btn-warnning" name="button">Edit</button></a> -->
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection
