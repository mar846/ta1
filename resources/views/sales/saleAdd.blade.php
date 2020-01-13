@extends('layouts.app')
@section('title','Sales Add')
@section('content')
<div class="m-3">
  <h3 class="mb-3">Sales Add</h3>
  <form action="{{ route('sales.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="costumer" value="{{ old('costumer') }}" list="dataCustomer" onchange="getCustomerID(this)">
            @error('costumer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="8" cols="80">{{ old('address') }}</textarea>
            @error('capacity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Phone</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <input type="data" class="form-control" name="referenceDate" placeholder="dd-mm-yyyy" value="{{ old('referenceDate') }}">
          </div>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
        <th></th>
      </tr>
      <?php
        for ($i=0; $i < 11; $i++) {
          ?>
          <tr>
            <td><input type="text" name="item{{ $i }}" class="form-control" list="dataBarang"></td>
            <td>
              <div class="input-group mb-2">
                <input type="number" class="form-control" name="qty{{ $i }}" placeholder="1" onkeyup="calculate(this)" id="qty{{ $i }}">
                <div class="input-group-prepend">
                  <div class="input-group-text">pcs</div>
                </div>
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" class="form-control" name="price{{ $i }}" placeholder="1000" onkeyup="calculate(this)" id="price{{ $i }}">
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" class="form-control" name="price{{ $i }}" placeholder="1000" id="subtotal{{ $i }}">
              </div>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm" name="button">X</button></td>
          </tr>
          <?php
        }
      ?>
    </table>
    <input type="hidden" name="totalItem" value="{{ $i-=1 }}">
    <button type="submit" class="btn btn-success col-12" name="button">Create Sale</button>
  </form>
</div>
<datalist id="dataCustomer">
  @foreach($company as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
<datalist id="dataBarang">
  @foreach($panel as $data)
    <option value="{{ $data->name }}">
  @endforeach
  @foreach($inverter as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
@endsection
@section('script')
<script type="text/javascript">
  function calculate(id) {
    var row = id.name.substring(id.name.length-1,id.name.length);
    console.log(row);
    $('#subtotal'+row).val($('#qty'+row).val()*$('#price'+row).val());
  }
</script>
@endsection
