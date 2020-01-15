@extends('layouts.app')
@section('title','Edit Address')
@section('content')
<form class="px-1" action="{{ route('addresses.update',$address->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <h2>Edit {{ $address->companies->name }} Address</h2>
  <div class="form-group row">
    <label class="col-sm-1 col-form-label">Branch</label>
    <div class="col-sm-11">
      <input name="branch" class="form-control" value="{{ old('branch', $address->name) }}">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-form-label">Address</label>
    <div class="col-sm-11">
      <textarea name="address" class="form-control" rows="8" cols="80">{{ old('address', $address->address) }}</textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-form-label">Phone</label>
    <div class="col-sm-11">
      <input type="text" name="phone" class="form-control" value="{{ old('phone', $address->phone) }}">
    </div>
  </div>
  <div class="form-group row">
    <button type="submit" class="col-12 btn btn-success" name="button">Update</button>
  </div>
</form>
@endsection
