@extends('layouts.master')
@section('title','Sales Add')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
<li class="breadcrumb-item active">Add Sale</li>
@endsection
@section('content')
<div class="m-3">
  <form action="{{ route('sales.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}" list="dataCustomer" onchange="getCustomerData(this)">
            @error('company')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Bill To</label>
          <div class="col-sm-10">
            <input type="text" name="billTo" class="form-control @error('billTo') is-invalid @enderror" value="{{ old('billTo') }}" list="addresses" id="billTo" onkeyup="address()">
            @error('billTo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Ship To</label>
          <div class="col-sm-10">
            <input type="text" name="shipTo" class="form-control @error('shipTo') is-invalid @enderror" value="{{ old('shipTo') }}" list="addresses" id="shipTo">
            @error('shipTo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <!-- <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="8" cols="80">{{ old('address') }}</textarea>
            @error('capacity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div> -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Phone</label>
          <div class="col-sm-10">
            <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" name="referenceDate" placeholder="dd-mm-yyyy" value="{{ old('referenceDate') }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Payment Terms</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('paymentTerms') is-invalid @enderror" name="paymentTerms" value="{{ old('paymentTerms') }}">
            @error('paymentTerms')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Delivery Time</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('deliveryTime') is-invalid @enderror" name="deliveryTime" value="{{ old('deliveryTime') }}">
            @error('deliveryTime')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Subtotal</th>
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
          <td>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp.</div>
              </div>
              <input type="number" class="form-control" name="price0" placeholder="1000" onkeyup="calculate(this)" id="price0">
            </div>
          </td>
          <td>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp.</div>
              </div>
              <input type="number" class="form-control" name="subtotal0" placeholder="1000" id="subtotal0">
            </div>
          </td>
          <td><button type="button" class="btn btn-danger btn-sm" id="button0" name="button0" onclick="deleteRow(this)">X</button></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-right">Total</th>
          <th id="totalColumn"></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
    <button type="button" class="btn btn-secondary" name="button" onclick="addRow()">Add Row</button>
    <input type="hidden" name="totalItem" id="totalItem" value="0">
    <input type="hidden" name="total" id="total">
    <button type="submit" class="btn btn-success col-12" name="button">Create Sale</button>
  </form>
</div>
<datalist id="dataCustomer">
  @foreach($company as $data)
    <option value="{{ $data->name }}">
  @endforeach
</datalist>
<datalist id="addresses"></datalist>
@endsection
@section('script')
<script type="text/javascript">
  var i = 1;
  function addRow() {
    $('#tableItem').append("<tr><td><input type='text' name='item" + i + "' class='form-control' placeholder='@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach'></td><td><div class='input-group mb-2'><input type='number' class='form-control' name='qty" + i + "' placeholder='1' onkeyup='calculate(this)' id='qty" + i + "'><div class='input-group-prepend'><input type='text' name='unit" + i + "' class='input-group-text' placeholder='@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach' id='unit" + i + "'></div></div></td><td><div class='input-group mb-2'><div class='input-group-prepend'><div class='input-group-text'>Rp.</div></div><input type='number' class='form-control' name='price" + i + "' placeholder='1000' onkeyup='calculate(this)' id='price" + i + "'></div></td><td><div class='input-group mb-2'><div class='input-group-prepend'><div class='input-group-text'>Rp.</div></div><input type='number' class='form-control' name='subtotal" + i + "' placeholder='1000' id='subtotal" + i + "'></div></td><td><button type='button' class='btn btn-danger btn-sm' id='button" + i + "' name='button" + i + "' onclick='deleteRow(this)'>X</button></td></tr>");
    i+=1;
    $('#totalItem').val(i);
  }
  function deleteRow(id) {
    var row = id.name.substring(id.name.length-1,id.name.length);
    $('#button'+row).closest('tr').remove();
    i-=1;
    $('#totalItem').val(i);
  }
  function address() {
    $('#shipTo').val($('#billTo').val());
  }
  function calculateTotal() {
    console.clear()
    var total = 0;
    // console.log(total);
    for (var i = 0; i < $('#totalItem').val()+1; i++) {
      total += $('#subtotal'+i).val()*1;
      // console.log($('#subtotal'+i).val()*1);
    }
    console.log(total);
    $('#totalColumn').html(total);
  }
  function calculate(id) {
    var row = id.name.substring(id.name.length-1,id.name.length);
    // console.log($('#qty'+row).val());
    var subtotal = $('#qty'+row).val()*1 * $('#price'+row).val()*1;
    $('#subtotal'+row).val(subtotal);
    calculateTotal();
  }
  function getCustomerData(name) {
    $.post("{{ route('getCompanyData') }}",{name:name.value,_token:'{{ Session::token() }}'},function(data){
      $('#addresses').html();
      for (var i = 0; i < data.length; i++) {
        $('#addresses').append('<option value="' + data[i].address + '">');
      }
      $('#phone').val(data.phone);
    });
  }
</script>
@endsection
