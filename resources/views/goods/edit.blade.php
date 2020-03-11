@extends('layouts.master')
@section('title','Edit Good')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Edit Good</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<!-- {{ $good }} -->
<form action="{{ route('goods.update',[$good->id]) }}" method="post">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="pce, pcs, unit, kg, g,....." name="name" value="{{ old('name',$good->name) }}">
      @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-2">
      <label class="col-form-label">Unit</label>
    </div>
    <div class="col-sm-10">
      <select class="form-control" name="unit">
        <option>Select Unit</option>
        @foreach($unit as $data)
        <option value="{{ $data->id }}" @if($data->id == $good->unit_id) selected @endif>{{ $data->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Type</label>
    <div class="col-sm-10">
      <select class="form-control" name="type">
        <option>Choose Type</option>
        @foreach($type as $data)
          <option value="{{ $data->id }}" @if($data->id == $good->type_id) selected @endif>{{ $data->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
      <textarea name="description" class="form-control" rows="8" cols="80">{{ old('description',$good->description) }}</textarea>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Supplier</label>
    <div class="col-sm-10">
      <select class="form-control" name="supplier">
        @foreach($company as $data)
          @if($data->type == 'supplier')
          <option value="{{ $data->id }}">{{ $data->name }}</option>
          @endif
        @endforeach
      </select>
        <!-- @foreach($company as $data)
            <input type="checkbox" class="form-check-input" name="supplier[]" value="{{ $data->id }}">
            <label class="form-check-label">{{  $data->name }}</label><br>
          @endforeach -->
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" name="price" value="{{ old('price',$good->price) }}">
    </div>
  </div>
  @isset($good->type_id)
    @if($good->types->name == 'Panel' || $good->types->name == 'Inverter')
    <div class="form-group row">
      <label class="col-sm-2 col-label-form">Capacity</label>
      <div class="col-sm-10">
        <input type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" placeholder="Capacity Wp" value="{{ old('capacity',$good->spec->capacity) }}">
        @error('capacity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-label-form">Minimum and Maximum Voltage</label>
      <div class="form-row pl-3">
        <div class="col">
          <input type="number" class="form-control @error('minVolt') is-invalid @enderror" name="minVolt" placeholder="Minimum Volt" value="{{ old('minVolt',$good->spec->minVolt) }}">
          @error('minVolt')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="col">
          <input type="number" class="form-control @error('maxVolt') is-invalid @enderror" name="maxVolt" placeholder="Maximum Volt" value="{{ old('maxVolt',$good->spec->maxVolt) }}">
          @error('maxVolt')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-label-form">Efficiency</label>
      <div class="col-sm-10">
        <input type="number" class="form-control @error('efficiency') is-invalid @enderror" name="efficiency" placeholder="Efficiency" value="{{ old('efficiency',$good->spec->efficiency) }}">
        @error('efficiency')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-label-form">Safety Margin</label>
      <div class="col-sm-10">
        <input type="number" class="form-control @error('safetyMargin') is-invalid @enderror" name="safetyMargin" placeholder="Safety Martgin in percentage" value="{{ old('safetyMargin',$good->spec->safetyMargin) }}">
        @error('safetyMargin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    @endif
  @endisset
  <!--
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Storage Location</label>
    <div class="col-sm-10">
      <select class="form-control" name="warehouse">
        <option value="">Select Warehouse</option>

      </select>
    </div>
  </div> -->
  <div class="form-group row">
    <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
  </div>
</form>
@endsection
