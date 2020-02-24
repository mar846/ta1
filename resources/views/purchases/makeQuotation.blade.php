@extends('layouts.master')
@section('title','Purchase Quotation')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Purchase Quotation</li>
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('purchases.store') }}" method="post">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Project</label>
        <div class="col-sm-10">
          <input type="hidden" name="project" value="{{ old('project',$project->id) }}">
          <p class="form-control">{{ $project->name }}</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Supplier</label>
        <div class="col-sm-10">
          <input type="hidden" name="company" value="{{ old('company',$company->id) }}">
          <p class="form-control">{{ $company->name }}</p>
        </div>
      </div>
      @foreach($company->addresses as $data)
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <input type="hidden" name="address" value="{{ old('company', $data->id) }}">
            <p class="form-control">{{ $data->address }}</p>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Phone</label>
          <div class="col-sm-10">
            <p class="form-control">{{ $data->phone }}</p>
            <input type="hidden" name="phone" value="{{ old('phone',$data->phone) }}">
          </div>
        </div>
      @endforeach
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
          <input type="text" class="form-control @error('paymentTerms') is-invalid @enderror" name="paymentTerms" value="{{ old('paymentTerms','DP 50% pada saat surat order diterima SIsa 50% pada saat barang diambil') }}">
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
          <input type="text" class="form-control @error('deliveryTime') is-invalid @enderror" name="deliveryTime" value="{{ old('deliveryTime', '4 - 5 bulan setelah terima DP') }}">
          @error('deliveryTime')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 0; @endphp
      @foreach($project->designers as $key =>$data)
        @foreach($data->goods as $index => $datas)
        @if($datas->company_id == $company->id)
        <tr>
            <td>
              {{ $datas->name }}
              <input type="hidden" name="item{{ $i }}" value="{{ old('item.$i',$datas->name) }}">
            </td>
            <td>
              {{ $datas->pivot->qty }} {{ $datas->units->name }}
              <input type="hidden" name="qty{{ $i }}" value="{{ old('qty.$i',$datas->pivot->qty) }}" id="qty{{ $i }}">
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" class="form-control" name="price{{ $i }}" placeholder="1000" onkeyup="calculate(this)" id="price{{ $i }}" value="{{ old('price.$i',($datas->price)) }}">
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <p class="form-control" id="subTotalShow{{$i}}">{{ $datas->pivot->qty * $datas->price }}</p>
                <input type="hidden" class="form-control" name="subtotal{{ $i }}" placeholder="1000" onkeyup="calculate(this)" id="subtotal{{ $i }}" value="{{ old('subtotal.$index',($datas->pivot->qty * $datas->price * $datas->profit)) }}">
              </div>
            </td>
          </tr>
          @php $i+=1; @endphp
        @endif
        @endforeach
      @endforeach
    </tbody>
  </table>
  <hr>
  <div class="form-group row">
    <button type="submit" class="btn btn-success col-12" name="button">Make Quotation</button>
  </div>
</form>
@endsection
@section('script')
<script type="text/javascript">
  function calculate(id) {
    var row = id.name.substring(id.name.length-1,id.name.length);
    // console.log($('#qty'+row).val());
    var subtotal = $('#qty'+row).val()*1 * $('#price'+row).val()*1;
    $('#subtotal'+row).val(subtotal);
    $('#subTotalShow'+row).html('');
    $('#subTotalShow'+row).html(subtotal);
  }
</script>
@endsection
