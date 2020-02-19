@extends('layouts.master')
@section('roles','active')
@section('title','Role Edit')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
<li class="breadcrumb-item active">Role Edit</li>
@endsection
@section('content')
<form action="{{ route('roles.update',$role->id) }}" method="post">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$role->name) }}">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
  </div>
</form>
@endsection
@section('script')
@endsection
