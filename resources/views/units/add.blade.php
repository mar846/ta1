@extends('layouts.master')
@section('title','Units')
@section('units','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a></li>
<li class="breadcrumb-item active">Add Unit</li>
@endsection
@section('content')
<!-- form start -->
<form action="{{ route('units.store') }}" method="post">
  {{ csrf_field() }}
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Name</label>
      <div class="col-sm-11">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Unit name">
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
    <button type="submit" class="btn btn-success">Add</button>
    <a href="{{ route('units.index') }}"><button type="button" class="btn btn-default float-right">Cancel</button></a>
  </div>
  <!-- /.card-footer -->
</form>
@endsection
