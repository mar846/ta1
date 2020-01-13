@extends('layouts.app')
@section('title','Edit Good')
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="container">
  <h3>Edit Good</h3>
  <form action="{{ route('goods.update',[$good->id]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" placeholder="pce, pcs, unit, kg, g,....." name="name" value="{{ $good->name }}">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2">
        <label class="col-form-label">QTY</label>
      </div>
      <div class="col-sm-2">
        <input type="number" class="form-control" name="qty" placeholder="50" value="{{ $good->qty }}">
      </div>
      <div class="col-sm-2">
        <select class="form-control" name="unit">
          <option>Select Unit</option>
          @foreach($unit as $data)
            <option value="{{ $data->id }}" @if($data->id == $good->unit_id) selected @endif>{{ $data->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Supplier</label>
      <div class="col-sm-10">
        <select class="form-control" name="company">
          <option value="">Select Supplier</option>
          @foreach($company as $data)
            <option value="{{ $data->id }}" @if($data->id == $good->company_id) selected @endif>{{ $data->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Storage Location</label>
      <div class="col-sm-10">
        <select class="form-control" name="warehouse">
          <option value="">Select Warehouse</option>
          @foreach($warehouse as $data)
            <option value="{{ $data->id }}"@if($data->id == $good->warehouse_id) selected @endif>{{ $data->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-12 text-right">
        <button type="submit" class="btn btn-success" name="button">Add</button>
      </div>
    </div>
  </form>
</div>
@endsection
