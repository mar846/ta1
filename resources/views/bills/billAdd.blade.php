@extends('layouts.app')
@section('title','Add Bill of Materials')
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<h3>Add Bill of Materials</h3>
<form action="{{ url('bills') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row my-3">
    <label class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="@foreach($product as $key => $data)@if($key > 0), @endif{{ $data->name }}@endforeach">
      @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <div class="form-group row my-3">
    <label class="col-sm-2 col-form-label">Quantity</label>
    <div class="col-sm-10">
      <div class="input-group mb-2">
        <input type="text" class="form-control" name="qty" value="{{ old('qty') }}" placeholder="1">
        @error('qty')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <div class="input-group-prepend">
          <input type="text" name="unit" class="input-group-text" value="{{ old('unit') }}" placeholder="@foreach($unit as $key => $data)@if($key > 0), @endif{{ $data->name }}@endforeach">
        </div>
    </div>
  </div>
</div>
  <div class="form-group row my-3">
    <label class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-10">
      <textarea class="form-control" name="description">{{ old('description') }}</textarea>
      @error('name')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
    </div>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>QTY</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php for ($i = 0; $i < old('totalItem',11); $i++): ?>
        <tr>
          <td><input type="text" name="item{{$i}}" class="form-control" placeholder="@foreach($raw as $key => $data)@if($key > 0), @endif{{ $data->name }}@endforeach" value="{{ old('item'.$i) }}"></td>
          <td>
            <div class="input-group mb-2">
              <input type="text" name="qty{{$i}}" class="form-control" value="{{ old('qty'.$i) }}">
              <div class="input-group-prepend">
                <input type="text" name="unit{{$i}}" class="input-group-text" value="{{ old('unit'.$i) }}" placeholder="@foreach($unit as $key => $data)@if($key > 0), @endif{{ $data->name }}@endforeach">
              </div>
            </div>
          </td>
          <td><input type="text" name="description{{$i}}" class="form-control"></td>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>
  <hr>
  <input type="hidden" name="totalItem" value="{{ old('totalItem',$i) }}">
  <button type="submit" name="button" class="btn btn-success col-12">Add</button>
</form>
@endsection
