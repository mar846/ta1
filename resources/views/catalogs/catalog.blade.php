@extends('layouts.app')
@section('title','List Catalog')
@section('content')
<div class="m-3">
  <div class="row justify-content-between my-3">
    <h3>List Catalog</h3>
    @can('create',App\Catalog::class)
      <a href="{{ route('catalogs.create') }}"><button type="button" class="btn btn-success" name="button">Add Catalog</button></a>
    @endcan
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Capacity</th>
      <th></th>
    </tr>
    @foreach($catalog as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->capacity }}</td>
        <td>
          @can('view',$data)
          <a href="{{ route('catalogs.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          @endcan
          @can('update',$data)
          <a href="{{ route('catalogs.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
          @endcan
        </td>
      </tr>
    @endforeach
  </table>
</div>
@endsection
