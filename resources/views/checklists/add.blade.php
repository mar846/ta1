@extends('layouts.app')
@section('title','Add Checklist')
@section('content')
<h3>Add Checklist</h3>
<form action="{{ url('checklists') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row">
    <label  class="col-sm-1 col-form-label">Question</label>
    <div class="col-sm-11">
      <input type="text" name="question" class="form-control" id="inputQuestion">
    </div>
  </div>
  <button type="submit" class="btn btn-success col-sm-11 offset-sm-1" name="button">Add</button>
</form>
@endsection
