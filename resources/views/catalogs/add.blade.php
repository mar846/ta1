@extends('layouts.master')
@section('title','Add Catalog')
@section('products','active')
@section('catalogs','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('catalogs.index') }}">Catalogs</a></li>
<li class="breadcrumb-item active">Add Catalog</li>
@endsection
@section('content')
<div class="m-3">
  <form action="{{ route('catalogs.store') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Household" name="name" value="{{ old('name') }}">
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
        <input type="text" name="capacity" class="form-control @error('capacity') is-invalid @enderror" placeholder="100" value="{{ old('capacity') }}">
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
        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="8" cols="80">{{ old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label>Items</label>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Item</th>
            <th>Qty</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tableItem">
          <tr>
            <td><input type="text" name="item0" class="form-control" placeholder="@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach" list="dataGoods"></td>
            <td>
              <div class="input-group mb-2">
                <input type="number" class="form-control" name="qty0" placeholder="1" onkeyup="calculate(this)" id="qty0">
                <div class="input-group-prepend">
                  <input type="text" name="unit0" class="input-group-text" placeholder="@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach" id="unit0" list="dataUnits">
                </div>
              </div>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm" id="button0" name="button0" onclick="deleteRow(this)">X</button></td>
          </tr>
        </tbody>
      </table>
      <button type="button" name="button" class="btn btn-secondary" onclick="addRow()">Add Row</button>
    </div>
    <div class="form-group row">
      <div class="col-12 text-right">
        <input type="hidden" name="totalItem" id="totalItem">
        <button type="submit" class="btn btn-success" name="button">Add</button>
      </div>
    </div>
  </form>
</div>
<datalist id="dataGoods">
  @foreach($good as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
<datalist id="dataUnits">
  @foreach($unit as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
@endsection
@section('script')
<script type="text/javascript">
var i = 1;
function addRow() {
  $('#tableItem').append("<tr><td><input type='text' name='item" + i + "' class='form-control' placeholder='@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach' list='dataGoods'></td><td><div class='input-group mb-2'><input type='number' class='form-control' name='qty" + i + "' placeholder='1' onkeyup='calculate(this)' id='qty" + i + "'><div class='input-group-prepend'><input type='text' name='unit" + i + "' class='input-group-text' placeholder='@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach' id='unit" + i + "' list='dataUnits'></div></div></td><td><button type='button' class='btn btn-danger btn-sm' id='button" + i + "' name='button" + i + "' onclick='deleteRow(this)'>X</button></td></tr>");
  i+=1;
  $('#totalItem').val(i);
}
function deleteRow(id) {
  var row = id.name.substring(id.name.length-1,id.name.length);
  $('#button'+row).closest('tr').remove();
  i-=1;
  $('#totalItem').val(i);
}
</script>
@endsection
