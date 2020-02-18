@extends('layouts.master')
@section('title','Edit Designer')
@section('designers','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('designers.index') }}">Designers</a></li>
<li class="breadcrumb-item active">Edit Designers</li>
@endsection
@section('content')
@section('content')
<form action="{{ route('designers.update',$designer->id) }}" method="post" enctype="multipart/form-data">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label>Project</label>
          <label class="form-control">{{ $designer->projects->name }}</label>
        </div>
        <div class="form-group d-flex flex-column">
          <label for="exampleInputFile">File input</label>
          <input type="file" name="files" multiple>
          <!-- <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="exampleInputFile">
              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
            </div>
            <div class="input-group-append">
              <span class="input-group-text" id="">Upload</span>
            </div>
          </div> -->
        </div>
        <label>Items</label>
        @foreach($designer->goods as $key => $data)
        {{ $data->name }}<br><br>
        @endforeach
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Item</th>
              <th>Qty</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="tableItem">
            @foreach($designer->goods as $key => $data)
              <tr>
                <td><input type="text" name="item{{ $key }}" class="form-control" list="dataGoods" value="{{ old('item.$key',$data->name) }}" disabled></td>
                <td>
                  <div class="input-group mb-2">
                    <input type="number" class="form-control" name="qty{{ $key }}" onkeyup="calculate(this)" id="qty{{ $key }}" value="{{ old('qty.$key',$data->pivot->qty) }}" disabled>
                    <div class="input-group-prepend">
                      <input type="text" name="unit{{ $key }}" class="input-group-text" id="unit{{ $key }}" list="dataUnits" value="{{ old('unit.$key',$data->units->name) }}" disabled>
                    </div>
                  </div>
                </td>
                <td>
                  <input type="hidden" name="designer{{$key}}" id="designer" value="{{ $designer->id }}">
                  <button type="button" class="btn btn-danger btn-sm" id="button{{ $data->id }}" name="button{{ $data->id }}" onclick="deleteRow(this)" value="{{ $data->id }}">X</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <button type="button" name="button" class="btn btn-secondary" onclick="addRow()">Add Item</button>
        <div class="form-group row">
          <div class="col-12">
            <input type="hidden" name="totalItem" id="totalItem" value="{{ $key+1 }}">
            <button type="submit" class="btn btn-success col-12">Submit</button>
          </div>
        </div>
      </div>
  </div>
</form>
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
var i = {{ $key+1 }};
function addRow() {
  $('#tableItem').append("<tr><td><input type='text' name='item" + i + "' class='form-control' placeholder='@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach'></td><td><div class='input-group mb-2'><input type='number' class='form-control' name='qty" + i + "' placeholder='1' onkeyup='calculate(this)' id='qty" + i + "'><div class='input-group-prepend'><input type='text' name='unit" + i + "' class='input-group-text' placeholder='@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach' id='unit" + i + "'></div></div></td><td><button type='button' class='btn btn-danger btn-sm' id='button" + i + "' name='button" + i + "' onclick='deleteRow(this)'>X</button></td></tr>");
  i+=1;
  $('#totalItem').val(i);
}
function deleteRow(id) {
  $.post("{{ route('deleteGood') }}",{id:id.value,designer:$('#designer').val(),_token:'{{ Session::token() }}'},function(data){});
  console.log(id);
  var row = id.name.substring(id.name.length-1,id.name.length);
  $('#button'+row).closest('tr').remove();
}
</script>
@endsection
