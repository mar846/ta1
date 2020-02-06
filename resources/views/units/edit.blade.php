@extends('layouts.master')
@section('title','Edit Unit')
@section('units','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a></li>
<li class="breadcrumb-item active">Edit Unit</li>
@endsection
@section('content')
<!-- form start -->
<form action="{{ route('units.update',$unit->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Name</label>
      <div class="col-sm-11">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Unit name" value="{{ old('name',$unit->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="px-3">
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('units.index') }}"><button type="button" class="btn btn-default float-right">Cancel</button></a>
  </div>
  <!-- /.card-footer -->
</form>
@endsection
