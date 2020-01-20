@extends('layouts.app')
@section('title','Purchases')
@section('content')
<div class="m-3">
  <div class="row justify-content-between px-3 pb-2">
    <h3>Purchases</h3>
    @can('create',App\Sale::class)
      <a href="{{ route('purchases.create') }}"><button type="button" class="btn btn-success" name="button">Add</button></a>
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
          @can('update',$data)
          <a href="{{ route('purchases.edit',[$data->id]) }}"><button type="button" class="btn btn-warnning" name="button">Edit</button></a>
          @endcan
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection
