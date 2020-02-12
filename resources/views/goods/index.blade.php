@extends('layouts.master')
@section('title','List Good')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Goods</li>
@endsection
@section('content')
<div class="row justify-content-between my-3">
  <div class="col-12">
    <a href="{{ route('goods.create') }}" class="btn btn-primary">Add Good</a>
  </div>
</div>
<table class="table">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Supplier</th>
    <th>QTY</th>
    <th>Type</th>
    <th></th>
  </tr>
  @foreach($good as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->name }}</td>
      <td>@foreach($data->companies as $key => $datas) @if($key>0) , @endif {{ $datas->name }} @endforeach</td>
      <td>{{ $data->qty }} {{ $data->units->name }}</td>
      <td>{{ $data->type }}</td>
      <td>
        <a href="{{ route('goods.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
        <a href="{{ route('goods.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
      </td>
    </tr>
  @endforeach
</table>
@endsection
