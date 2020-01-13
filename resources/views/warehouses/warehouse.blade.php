@extends('layouts.app')
@section('title','List Warehouse')
@section('content')
<div class="">
  <div class="row justify-content-between my-3">
    <h3>List Warehouse</h3>
    @can('create',App\Warehouse::class)
    <a href="{{ route('warehouses.create') }}"><button type="button" class="btn btn-success" name="button">Add Warehouse</button></a>
    @endcan
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Location</th>
      <th></th>
    </tr>
    @foreach($warehouse as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->location }}</td>
        <td>
          @can('view',$data)
          <a href="{{ route('warehouses.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          @endcan
          @can('update',$data)
          <a href="{{ route('warehouses.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
          @endcan
        </td>
      </tr>
    @endforeach
  </table>
  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      {{ $warehouse->links() }}
    </div>
  </div>
</div>
@endsection
