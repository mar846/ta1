@extends('layouts.master')
@section('project','active')
@section('title','Projects Add')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">Projects Add</li>
@endsection
@section('content')
<form action="{{ route('projects.store') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="inputName">Project Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="inputName">Project Locations</label>
    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
    @error('location')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="inputName">Project Capacity</label>
    <div class="form-inline">
      <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity') }}">
      @error('capacity')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
      <select class="form-control @error('unit') is-invalid @enderror" name="unit">
        <option value="W">W</option>
        <option value="KW">KW</option>
        <option value="MW">MW</option>
      </select>
      @error('unit')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group">
    <label for="inputDescription">Project Description</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="inputClientCompany">Customer</label>
    <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}">
    @error('company')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="inputClientCompany">Bill To</label>
    <textarea name="billTo" class="form-control @error('billTo') is-invalid @enderror" rows="3" cols="80">{{ old('billTo') }}</textarea>
    @error('billTo')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="inputClientCompany">Ship To</label>
    <textarea name="shipTo" class="form-control @error('shipTo') is-invalid @enderror" rows="3" cols="80">{{ old('shipTo') }}</textarea>
    @error('shipTo')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="inputClientCompany">Phone</label>
    <textarea name="phone" class="form-control @error('phone') is-invalid @enderror" rows="3" cols="80">{{ old('phone') }}</textarea>
    @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <!-- <div class="form-group">
    <label for="inputProjectLeader">Project Leader</label>
    <input type="text" id="inputProjectLeader" class="form-control">
  </div> -->
  <div class="form-group">
    <button type="submit" class="btn btn-success col-12" name="button">Create Project</button>
  </div>
</form>
@endsection
