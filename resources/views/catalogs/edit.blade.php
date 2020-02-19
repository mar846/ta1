@extends('layouts.master')
@section('title','Edit Catalog')
@section('products','active')
@section('catalogs','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('catalogs.index') }}">Catalogs</a></li>
<li class="breadcrumb-item active">Edit Catalog</li>
@endsection
@section('content')
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
  <label>Items</label>
  <div class="form-group row">
    <table class="table">
      <thead>
        <tr>
          <th>Item</th>
          <th>QTY</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="tableItem">
        @foreach($catalog->goods as $key => $data)
          <tr>
            <td><input type="text" name="item{{ $key }}" class="form-control" value="{{ old('item.$key',$data->name)  }}" disabled></td>
            <td>
              <div class="input-group mb-2">
                <input type="number" class="form-control" name="qty{{ $key }}" placeholder="1" id="qty{{ $key }}" value="{{ old('qty.$key',$data->pivot->qty) }}" disabled>
                <div class="input-group-prepend">
                  <input type="text" name="unit0" class="input-group-text" id="unit0" list="dataUnits" value="{{ old('unit.$key',$data->units->name) }}" disabled>
                </div>
              </div>
            </td>
            <td>
              <input type="hidden" name="catalog{{$key}}" id="catalog" value="{{ $catalog->id }}">
              <button type="button" class="btn btn-danger btn-sm" id="button{{ $data->id }}" name="button{{ $data->id }}" onclick="deleteRow(this)" value="{{ $data->id }}">X</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <button type="button" name="button" class="btn btn-secondary" onclick="addRow()">Add Row</button>
  </div>
  <div class="form-group row">
    <div class="col-12 text-right">
      <input type="hidden" name="totalItem" value="{{ $key+1 }}" id="totalItem">
      <button type="submit" class="btn btn-warning col-sm-10 offset-sm-2" name="button">Update</button>
    </div>
  </div>
</form>
@endsection
@section('script')
<script type="text/javascript">
var i = {{ $key+1 }};
function addRow() {
  $('#tableItem').append("<tr><td><input type='text' name='item" + i + "' class='form-control' placeholder='@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach'></td><td><div class='input-group mb-2'><input type='number' class='form-control' name='qty" + i + "' placeholder='1' onkeyup='calculate(this)' id='qty" + i + "'><div class='input-group-prepend'><input type='text' name='unit" + i + "' class='input-group-text' placeholder='@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach' id='unit" + i + "'></div></div></td><td><button type='button' class='btn btn-danger btn-sm' id='button" + i + "' name='button" + i + "' onclick='deleteRow(this)'>X</button></td></tr>");
  i+=1;
  $('#totalItem').val(i);
}
function deleteRow(id) {
  console.clear();
  $.post("{{ route('deleteCatalogGood') }}",{id:id.value,catalog:$('#catalog').val(),_token:'{{ Session::token() }}'},function(data){
    console.log(data);
  });
  var row = id.name.substring(id.name.length-1,id.name.length);
  $('#button'+row).closest('tr').remove();
}
</script>
@endsection
