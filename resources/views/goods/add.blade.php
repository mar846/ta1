@extends('layouts.master')
@section('title','Add Good')
@section('products','active')
@section('goods','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Goods</a></li>
<li class="breadcrumb-item active">Add Goods</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<form action="{{ route('goods.store') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row">
    <label class="col-sm-1 col-form-label">Name</label>
    <div class="col-sm-11">
      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Solar Panel, Inverter, Sun Logger" name="name" value="{{ old('name') }}">
      @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-1">
      <label class="col-form-label">Unit</label>
    </div>
    <div class="col-sm-11">
      <select class="form-control @error('qty') is-invalid @enderror" name="unit">
        @foreach($unit as $data)
          <option value="{{ $data->id }}">{{ $data->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-1">
      <label class="col-form-label">Price</label>
    </div>
    <div class="col-sm-11">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">Rp.</div>
        </div>
        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}">
        @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-1">
      <label class="col-form-label">Type</label>
    </div>
    <div class="col-sm-11">
      <select class="form-control @error('type') is-invalid @enderror" name="type">
        @foreach($type as $data)
          <option value="{{ $data->id }}">{{ $data->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-label-form">Description</label>
    <div class="col-sm-11">
      <textarea name="description" rows="8" cols="80" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
      @error('description')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-form-label">Supplier</label>
    <div class="col-sm-11">
      <select class="form-control" name="supplier">
        @foreach($company as $data)
          @if($data->type == 'supplier')
            <option value="{{ $data->id }}">{{ $data->name }}</option>
            <!-- <input type="checkbox" class="form-check-input" name="supplier[]" value="{{ $data->id }}">
            <label class="form-check-label">{{  $data->name }}</label><br> -->
          @endif
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-label-form">Capacity</label>
    <div class="col-sm-11">
      <input type="number" class="form-control @error('capacity') is-invalid @enderror" name="capacity" placeholder="Capacity Wp" value="{{ old('capacity') }}" step="0.01">
      @error('capacity')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-label-form">Max Current</label>
    <div class="col-sm-11">
      <input type="number" class="form-control @error('current') is-invalid @enderror" name="current" placeholder="Max Current" value="{{ old('current') }}" step="0.01">
      @error('current')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-label-form">Minimum and Maximum Voltage</label>
    <div class="form-row pl-3">
      <div class="col">
        <input type="number" class="form-control @error('minVolt') is-invalid @enderror" name="minVolt" placeholder="Minimum Volt" value="{{ old('minVolt') }}" step="0.01">
        @error('minVolt')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="col">
        <input type="number" class="form-control @error('maxVolt') is-invalid @enderror" name="maxVolt" placeholder="Maximum Volt" value="{{ old('maxVolt') }}" step="0.01">
        @error('maxVolt')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-label-form">Efficiency</label>
    <div class="col-sm-11">
      <input type="number" class="form-control @error('efficiency') is-invalid @enderror" name="efficiency" placeholder="Efficiency" value="{{ old('efficiency','97') }}" step="0.01">
      @error('efficiency')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-1 col-label-form">Safety Margin</label>
    <div class="col-sm-11">
      <input type="number" class="form-control @error('safetyMargin') is-invalid @enderror" name="safetyMargin" placeholder="Safety Martgin in percentage" value="{{ old('safetyMargin','5') }}">
      @error('safetyMargin')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row">
    <button type="submit" class="btn btn-success col-12" name="button">Add</button>
  </div>
</form>
<datalist id="dataCompany">
  @foreach($company as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
@endsection
