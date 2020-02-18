@extends('layouts.master')
@section('title','Catalog Info')
@section('products','active')
@section('catalogs','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('catalogs.index') }}">Catalogs</a></li>
<li class="breadcrumb-item active">Catalog Info</li>
@endsection
@section('content')
@can('update',$catalog)
<div class="row justify-content-end">
  <div class="col-2 text-right  mb-2">
    <a href="{{ route('catalogs.edit',$catalog->id) }}" class="btn btn-warning">Edit</a>
  </div>
</div>
@endcan
<div class="form-group row">
  <label class="col-sm-1">Name</label>
  <p class="form-control col-sm-11">{{ $catalog->name }}</p>
</div>
<div class="form-group row">
  <label class="col-sm-1">Capacity</label>
  <p class="form-control col-sm-11">{{ $catalog->capacity }}</p>
</div>
<div class="form-group row">
  <label class="col-sm-1">Description</label>
  <textarea class="form-control col-sm-11">{{ $catalog->description }}</textarea>
</div>
<table class="table">
  <thead>
    <tr>
      <th>Item</th>
      <th>QTY</th>
    </tr>
  </thead>
  <tbody>
    @foreach($catalog->goods as $data)
    <tr>
      <td>{{ $data->name }}</td>
      <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
