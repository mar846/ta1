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
<form action="{{ route('designers.store') }}" method="post" enctype="multipart/form-data">
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
                <td><input type="text" name="item{{ $key }}" class="form-control" list="dataGoods" value="{{ old('item.$key',$data->name) }}"></td>
                <td>
                  <div class="input-group mb-2">
                    <input type="number" class="form-control" name="qty{{ $key }}" onkeyup="calculate(this)" id="qty{{ $key }}" value="{{ old('qty.$key',$data->pivot->qty) }}">
                    <div class="input-group-prepend">
                      <input type="text" name="unit{{ $key }}" class="input-group-text" id="unit{{ $key }}" list="dataUnits" value="{{ old('unit.$key',$data->units->name) }}">
                    </div>
                  </div>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm" id="button{{ $key }}" name="button{{ $key }}" onclick="deleteRow(this)">X</button></td>
              </tr>
            @endforeach
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
