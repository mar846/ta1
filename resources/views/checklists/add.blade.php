@extends('layouts.master')
@section('title','Add Checklist')
@section('checklist','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('checklists.index') }}">Checklist</a></li>
<li class="breadcrumb-item active">Add Checklist1</li>
@endsection
@section('content')
<form action="{{ url('checklists') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row">
    <label  class="col-sm-1 col-form-label">Question</label>
    <div class="col-sm-11">
      <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" id="inputQuestion" autofocus>
      @error('question')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <button type="submit" class="btn btn-success col-sm-11 offset-sm-1" name="button">Add</button>
</form>
@endsection
