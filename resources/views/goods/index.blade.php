@extends('layouts.master')
@section('title','List Good')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Goods</li>
@endsection
@section('content')
@can('create', App\Good::class)
<div class="row justify-content-between my-3">
  <div class="col-12">
    <a href="{{ route('goods.create') }}" class="btn btn-primary">Add Good</a>
  </div>
</div>
@endcan
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
      <td>{{ $data->companies->name }}</td>
      <td>{{ $data->qty }} {{ $data->units->name }}</td>
      <td>{{ ($data->type_id != null)?$data->types->name:'' }}</td>
      <td>
        @can('viewAny',$data)
        <a href="{{ route('goods.show',[$data->id]) }}" class="btn btn-primary">Info</a>
        @endcan
      </td>
    </tr>
  @endforeach
</table>
@endsection
