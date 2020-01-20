@extends('layouts.app')
@section('title','List Good')
@section('content')
<div class="container">
  <div class="row justify-content-between my-3">
    <h3>Goods List</h3>
    <a href="{{ route('goods.create') }}"><button type="button" class="btn btn-success" name="button">Add Goods</button></a>
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Supplier</th>
      <th>QTY</th>
      <th>Location</th>
      <th></th>
    </tr>
    @foreach($good as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td>@foreach($data->companies as $key => $datas) @if($key>0) , @endif {{ $datas->name }} @endforeach</td>
        <td>{{ $data->qty }} {{ $data->units->name }}</td>
        <th>
          <a href="{{ route('goods.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          <a href="{{ route('goods.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
        </th>
      </tr>
    @endforeach
  </table>
</div>
@endsection
