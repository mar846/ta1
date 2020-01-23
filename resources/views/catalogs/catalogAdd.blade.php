@extends('layouts.app')
@section('title','Add Catalog')
@section('content')
<div class="container m-3">
  <h3>Add Catalog</h3>
  <form action="{{ route('catalogs.store') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Household" name="name" value="{{ old('name') }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Capacity</label>
      <div class="col-sm-10">
        <input type="text" name="capacity" class="form-control @error('capacity') is-invalid @enderror" placeholder="100" value="{{ old('capacity') }}">
        @error('capacity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-10">
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="8" cols="80">{{ old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <div class="col-12 text-right">
        <button type="submit" class="btn btn-success" name="button">Add</button>
      </div>
    </div>
  </form>
</div>
@endsection
