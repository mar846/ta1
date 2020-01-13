@extends('layouts.app')
@section('title','Warehouse '.$warehouse->name)
@section('content')
<div class="">
  <div class="row justify-content-between">
    <div class="col-3">
      <h3>Warehouse {{  $warehouse->name}}</h3>
      <label for="location">{{ $warehouse->location }}</label>
    </div>
    <a href="{{ route('warehouses.edit',[$warehouse->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
  </div>
  <table class="table">
    <tr>
      <th>Items</th>
      <th>Supplier</th>
      <th>QTY</th>
    </tr>
    <tr>
      <th colspan="3" class="text-center bg-light">Panels</th>
    </tr>
    @foreach($warehouse->panels as $data)
      <tr>
        <td><a href="{{ route('panels.show',[$data->id]) }}">{{ $data->name }}</a></td>
        <td><a href="{{ route('companies.show',[$data->companies->id]) }}">{{ $data->companies->name }}</a></td>
        <td>{{ $data->pivot->qty }} pcs</td>
      </tr>
    @endforeach
    <tr>
      <th colspan="3" class="text-center bg-light">Inverters</th>
    </tr>
    @foreach($warehouse->inverters as $data)
      <tr>
        <td><a href="{{ route('inverters.show',[$data->id]) }}">{{ $data->name }}</a></td>
        <td><a href="{{ route('companies.show',[$data->companies->id]) }}">{{ $data->companies->name }}</a></td>
        <td>{{ $data->pivot->qty }} pcs</td>
      </tr>
    @endforeach
  </table>
</div>
@endsection
