@extends('layouts.master')
@section('title','Projects Edit')
@section('project','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">Projects Edit</li>
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('projects.update',$project->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="inputName">Project Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$project->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputName">Project Locations</label>
        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location',$project->location) }}">
        @error('location')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputDescription">Project Description</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description',$project->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputName">Project Capacity</label>
        <div class="form-inline">
          <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity',$project->capacity) }}">
          @error('capacity')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
          @php $unit = ['W','KW','MW']; @endphp
          <select class="form-control @error('unit') is-invalid @enderror" name="unit">
            @foreach($unit as $key => $data)
            <option value="{{ $data }}" @if($data == $project->unit) selected @endif>{{ $data }}</option>
            @endforeach
          </select>
          @error('unit')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
      <div class="form-group">
        <label for="inputClientCompany">Customer</label>
        <input type="text" name="customer" class="form-control @error('customer') is-invalid @enderror" value="{{ old('customer',$project->companies->name) }}">
        @error('customer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      @foreach($project->companies->addresses as $data)
        @if($data->name == 'billTo')
          @php
            $billTo = $data->address;
            $phone = $data->phone;
          @endphp
        @elseif($data->name == 'shipTo')
          @php
            $shipTo = $data->address;
          @endphp
        @endif
      @endforeach
      <div class="form-group">
        <label for="inputClientCompany">Bill To</label>
        <input type="text" name="billTo" class="form-control @error('billTo') is-invalid @enderror" value="{{ old('billTo',$billTo) }}">
        @error('billTo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputClientCompany">Ship To</label>
        <input type="text" name="shipTo" class="form-control @error('shipTo') is-invalid @enderror" value="{{ old('shipTo',$shipTo) }}">
        @error('shipTo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputClientCompany">Phone</label>
        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$phone) }}">
        @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-warning col-12" name="button">Update Project</button>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</form>
<div class="card">
  <div class="card-body">
    <form action="{{ route('projects.destroy', $project->id)}}" method="post">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button class="btn btn-outline-danger col-12" type="submit">Delete</button>
    </form>
  </div>
</div>
@endsection
