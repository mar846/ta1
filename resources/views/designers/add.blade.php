@extends('layouts.master')
@section('title','Designer Add')
@section('designers','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('designers.index') }}">Designers</a></li>
<li class="breadcrumb-item active">Designers</li>
@endsection
@section('content')
<form action="{{ route('designers.store') }}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label>Project</label>
          <select class="form-control" name="project">
            <option>Choose Project</option>
            @foreach($project as $data)
              <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endforeach
          </select>
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
              <td><input type="text" name="item0" class="form-control" placeholder="@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach"></td>
              <td>
                <div class="input-group mb-2">
                  <input type="number" class="form-control" name="qty0" placeholder="1" onkeyup="calculate(this)" id="qty0">
                  <div class="input-group-prepend">
                    <input type="text" name="unit0" class="input-group-text" placeholder="@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach" id="unit0">
                  </div>
                </div>
              </td>
              <td><button type="button" class="btn btn-danger btn-sm" id="button0" name="button0" onclick="deleteRow(this)">X</button></td>
            </tr>
          </tbody>
        </table>
        <button type="button" name="button" class="btn btn-secondary" onclick="addRow()">Add Item</button>
        <div class="form-group row">
          <div class="col-12">
            <input type="hidden" name="totalItem" id="totalItem">
            <button type="submit" class="btn btn-success col-12">Submit</button>
          </div>
        </div>
      </div>
  </div>
</form>
@endsection
@section('script')
<script type="text/javascript">
var i = 1;
function addRow() {
  $('#tableItem').append("<tr><td><input type='text' name='item" + i + "' class='form-control' placeholder='@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach'></td><td><div class='input-group mb-2'><input type='number' class='form-control' name='qty" + i + "' placeholder='1' onkeyup='calculate(this)' id='qty" + i + "'><div class='input-group-prepend'><input type='text' name='unit" + i + "' class='input-group-text' placeholder='@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach' id='unit" + i + "'></div></div></td><td><button type='button' class='btn btn-danger btn-sm' id='button" + i + "' name='button" + i + "' onclick='deleteRow(this)'>X</button></td></tr>");
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
