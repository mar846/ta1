@extends('layouts.master')
@section('title','Purchase Add')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Purchase Add</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="m-3">
  <form action="{{ route('purchases.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Supplier</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" list="dataSupplier" value="{{ old('company') }}" onchange="getSupplierData(this)">
            @error('company')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" list="addresses">
            <!-- <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="8" cols="80">{{ old('address') }}</textarea> -->
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
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
      <div class="col-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" value="{{ old('reference') }}">
            @error('reference')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <input type="date" class="form-control @error('referenceDate') is-invalid @enderror" name="referenceDate" placeholder="dd-mm-yyyy" value="{{ old('referenceDate') }}">
            @error('referenceDate')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Sales Reference</label>
          <div class="col-sm-10">
            <select class="form-control" name="">
              <?php
                for ($i=0; $i < 10; $i++) {
                  ?>
                  <option value=""><?php echo $i ?></option>
                  <?php
                }
              ?>
            </select>
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
            <td><input type="text" name="item{{$i}}" class="form-control" placeholder="@foreach($good as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach"></td>
            <td>
              <div class="input-group mb-2">
                <input type="number" name="qty{{$i}}" class="form-control" name="qty" placeholder="1" id="qty{{$i}}" onkeyup="calculate(this)">
                <div class="input-group-prepend">
                  <input type="text" name="unit{{$i}}" class="input-group-text" placeholder="@foreach($unit as $key => $data)@if($key > 0),  @endif{{ $data->name }}@endforeach" id="unit{{$i}}">
                </div>
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" name="price{{$i}}" class="form-control" placeholder="1000" id="price{{$i}}" onkeyup="calculate(this)">
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" name="subtotal{{$i}}" class="form-control" placeholder="1000" id="subtotal{{$i}}">
              </div>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm" name="button">X</button></td>
          </tr>
          <?php
        }
      ?>
    </table>
    <input type="hidden" name="totalItem" value="{{ $i }}">
    <button type="submit" class="btn btn-success col-12" name="button">Add</button>
  </form>
</div>
<datalist id="dataSupplier">
  @foreach($company as $data)
  <option value="{{ $data->name }}">
  @endforeach
</datalist>
<datalist id="addresses"></datalist>
@endsection
@section('script')
  <script type="text/javascript">
    function calculate(id) {
      var row = id.name.substring(id.name.length-1,id.name.length);
      console.log(row);
      $('#subtotal'+row).val($('#qty'+row).val()*$('#price'+row).val());
    }
    function getSupplierData(name) {
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
