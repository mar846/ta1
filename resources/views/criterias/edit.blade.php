@extends('layouts.master')
@section('title','Edit Criteria')
@section('criteria','active')
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
