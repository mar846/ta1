@extends('layouts.master')
@section('title','Sale Quotation')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
<li class="breadcrumb-item active">Add Sale</li>
@endsection
@section('content')
<div class="m-3">
  <form action="{{ route('quotation') }}" method="get">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-12">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Project</label>
          <div class="col-sm-10">
            <select class="form-control" name="project" onchange="getCustomerData(this)">
              <option>Choose Project</option>
              @foreach($project as $data)
                @foreach($data->designers as $datas)
                  @if(count($data->sales) == 0)
                    @if($datas->supervisor_id != null)
                      <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endif
                  @endif
                @endforeach
              @endforeach
            </select>
          </div>
        </div>
        <!-- <div class="form-group row">
          <label class="col-sm-2 col-form-label">Customer</label>
          <div class="col-sm-10">
            <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}" list="dataCustomer" id="company">
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
        </div> -->
      </div>
      <!-- <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Valid Till</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" name="validTill" value="{{ old('validTill') }}">
          </div>
        </div>
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
        </tr>
      </thead>
      <tbody id="tableItem">
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-right">Total</th>
          <th id="totalColumn"></th>
        </tr>
      </tfoot>
    </table>
    <input type="hidden" name="totalItem" id="totalItem" value="0"> -->
    <button type="submit" class="btn btn-success col-12">Search Sale</button>
  </form>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  var i = 1;
  function address() {
    $('#shipTo').val($('#billTo').val());
  }
  function calculateTotal() {
    var total = 0;
    // console.log(total);
    for (var i = 0; i < $('#totalItem').val()+1; i++) {
      total += $('#subtotal'+i).val()*1;
      // console.log($('#subtotal'+i).val()*1);
    }
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
    $.post("{{ route('getCompanyData') }}",{id:name.value,_token:'{{ Session::token() }}'},function(data){
      console.log(data);
      $('#company').html();
      $('#company').val(data[0].name);
      $('#company').attr('readonly','true');
      $('#billTo').html();
      $('#billTo').val(data[0].addresses[0].address);
      $('#billTo').attr('readonly','true');
      $('#shipTo').html();
      $('#shipTo').val(data[0].addresses[0].address);
      $('#phone').html();
      $('#phone').val(data[0].addresses[0].phone);
      $('#phone').attr('readonly','true');
      for (var i = 0; i < data.length; i++) {
        $('#addresses').append('<option value="' + data[i].address + '">');
      }
      $('#phone').val(data.phone);
      getDesignerData(name.value);
    });
  }
  function getDesignerData(id) {
    $.post("{{ route('getDesignerData') }}",{id:id,_token:'{{ Session::token() }}'},function(data){
      console.log(data);
      for (var i = 0; i < data[0].goods.length; i++) {
        console.log(data[0].goods[i].name);
        $('#tableItem').html();
        $('#tableItem').append('<tr><td>' + data[0].goods[i].name + '<input type="hidden" name="item' + i + '" id="item0" value="' + data[0].goods[i].name + '"></td><td>' + data[0].goods[i].pivot.qty + ' ' + data[0].goods[i].units.name + '<input type="hidden" name="qty' + i + '" id="qty0" value="' + data[0].goods[i].pivot.qty + '"><input type="hidden" name="unit' + i + '" id="unit0" value="' + data[0].goods[i].units.name + '"></td><td><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">Rp.</div></div><input type="number" class="form-control" name="price' + i + '" placeholder="1000" onkeyup="calculate(this)" id="price' + i + '"></div></td><td><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">Rp.</div></div><input type="number" class="form-control" name="subtotal' + i + '" placeholder="1000" id="subtotal' + i + '"></div></td></tr>');
      }
      $('#totalItem').val(i);
    });
  }
</script>
@endsection
