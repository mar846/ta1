@extends('layouts.app')
@section('title','Catalog Info')
@section('content')
<div class="container">
  <div class="row justify-content-between my-3">
    <h3>{{ $catalog->name }} Catalog Info</h3>
    @can('update',$catalog)
    <a href="{{ route('catalogs.edit',[$catalog->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
    @endcan
  </div>
  <table class="table table-bordered">
    <tr>
      <th style="width:3vw;">Name</th>
      <td>{{ $catalog->name }}</td>
    </tr>
    <tr>
      <th>Capacity</th>
      <td>{{ $catalog->capacity }}</td>
    </tr>
    <tr>
      <th>Description</th>
      <td>{{ $catalog->description }}</td>
    </tr>
    <tr>
      <th>Items</th>
      <td>
        <table class="table table-bordered">
          <tr>
            <th>Item</th>
            <th>Supplier</th>
            <th>QTY</th>
          </tr>
          @foreach($catalog->panels as $data)
          <tr>
            <td><a href="{{ route('panels.show',[$data->id]) }}">{{ $data->name }}</a></td>
            <td><a href="{{ route('companies.show',[$data->companies->id]) }}">{{ $data->companies->name }}</a></td>
            <td>{{ $data->pivot->qty }} pcs</td>
          </tr>
          @endforeach
          @foreach($catalog->inverters as $data)
          <tr>
            <td><a href="{{ route('panels.show',[$data->id]) }}">{{ $data->name }}</a></td>
            <td><a href="{{ route('companies.show',[$data->companies->id]) }}">{{ $data->companies->name }}</a></td>
            <td>{{ $data->pivot->qty }} pcs</td>
          </tr>
          @endforeach
        </table>
      </td>
    </tr>
  </table>
</div>
@endsection
