@extends('layouts.app')
@section('title','Edit Catalog')
@section('content')
<div class="container m-3">
  <h3>Edit Catalog</h3>
  <form action="{{ route('catalogs.update',[$catalog->id]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Household" name="name" value="{{ old('name',$catalog->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Capacity</label>
      <div class="col-sm-10">
        <input type="text" name="capacity" class="form-control @error('capacity') is-invalid @enderror" placeholder="500 mW, 200 kW, 100 W" value="{{ old('capacity',$catalog->capacity) }}">
        @error('capacity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-10">
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="8" cols="80">{{ old('description',$catalog->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Panel</label>
      @foreach($catalog->panels as $datas)
      <div class="col-sm-5">
        <select class="form-control @error('panel') is-invalid @enderror" name="panel">
          <option>Select Panel</option>
          @foreach($panel as $data)
            <option value="{{ $data->id }}" @if($data->id == $datas->id) selected @endif>{{ $data->companies->name }} {{ $data->name }}</option>
          @endforeach
        </select>
        @error('panel')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="col-sm-5">
        <input type="number" name="panelQTY" class="form-control @error('panelQTY') is-invalid @enderror" placeholder="QTY" value="{{ old('panelQTY', $datas->pivot->qty) }}">
      </div>
      @endforeach
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Inverter</label>
      @foreach($catalog->inverters as $datas)
      <div class="col-sm-5">
        <select class="form-control @error('inverter') is-invalid @enderror" name="inverter">
          <option>Select Inverter</option>
          @foreach($inverter as $data)
            <option value="{{ $data->id }}" @if($data->id == $datas->id) selected @endif>{{ $data->companies->name }} {{ $data->name }}</option>
          @endforeach
        </select>
        @error('inverter')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <div class="col-sm-5">
        <input type="number" name="inverterQTY" class="form-control @error('inverterQTY') is-invalid @enderror" placeholder="QTY" value="{{ old('inverterQTY', $datas->pivot->qty) }}">
      </div>
      @endforeach
    </div>
    <div class="form-group row">
      <div class="col-12 text-right">
        <button type="submit" class="btn btn-success" name="button">Add</button>
      </div>
    </div>
  </form>
</div>
@endsection
