@extends('layouts.master')
@section('title','Edit Criteria')
@section('criteria','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active"><a href="{{ route('criterias.index') }}">Criteria</a></li>
<li class="breadcrumb-item active">Criteria Edit</li>
@endsection
@section('content')
<form action="{{ route('criterias.update',$criteria->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <div class="card-body">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <label for="name" class="col-form-label">{{ $criteria->name }}</label>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Weight</label>
      <div class="col-sm-10">
        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror" placeholder="1-5" value="{{ old('weight',$criteria->weight) }}">
        <small id="passwordHelpBlock" class="form-text text-muted">
          Higher are prioritize from 1 to 5
        </small>
        @error('weight')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
  </div>
  <div class="px-3">
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('criterias.index') }}"><button type="button" class="btn btn-default float-right">Cancel</button></a>
  </div>
</form>
@endsection
