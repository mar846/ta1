@extends('layouts.master')
@section('title','Edit Type')
@section('types','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('types.index') }}">Types</a></li>
<li class="breadcrumb-item active">Edit Type</li>
@endsection
@section('content')
<form action="{{ route('types.update',$type->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-1 col-form-label">Name</label>
      <div class="col-sm-11">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Type name" value="{{ old('name',$type->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
  </div>
  <div class="px-3">
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('types.index') }}"><button type="button" class="btn btn-default float-right">Cancel</button></a>
  </div>
</form>
@endsection
