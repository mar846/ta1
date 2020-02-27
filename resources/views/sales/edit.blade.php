@extends('layouts.master')
@section('title','Sales')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
<li class="breadcrumb-item active">Sales Edit</li>
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
<form action="{{ route('sales.update',$sale->projects->id) }}" method="post">
  {{ method_field('PUT') }}
  {{ csrf_field() }}
  <div class="card card-default">
    <div class="card-header">
      <h3 class="card-title">Sales SO-{{ $sale->so }}</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Project</label>
            <div class="col-sm-10">
              <p class="form-control">{{ $sale->projects->name }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Customer</label>
            <div class="col-sm-10">
              <p class="form-control">{{ $sale->bills->companies->name }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Bill To</label>
            <div class="col-sm-10">
              <p class="form-control">{{ $sale->bills->address }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Ship To</label>
            <div class="col-sm-10">
              <p class="form-control">{{ $sale->ships->address }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Valid Till</label>
            <div class="col-sm-10">
              <input type="date" name="validTill" class="form-control" max="{{ date('Y-m-d',time()+(86400*30)) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Reference</label>
            <div class="col-sm-10">
              <p class="form-control">{{ $sale->reference }}</p>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Reference Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="referenceDate" value="{{ old('referenceDate',$sale->referenceDate) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Payment Terms</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="paymentTerms" value="{{ old('paymentTerms',$sale->paymentTerms) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Delivery Time</label>
            <div class="col-sm-10">
              <input type="text" class="form-control-plaintext border rounded pl-3" name="deliveryTime" value="{{ old('deliveryTime',$sale->deliveryTime) }}">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <table class="table table-hover table-bordered col-12">
          <thead>
            <th>Item</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Subtotal</th>
          </thead>
          <tbody>
            @foreach($sale->goods as $key => $data)
              <tr>
                <td>{{ $data->name }}</td>
                <td>
                  {{ $data->pivot->qty }} {{ $data->units->name }}
                  <input type="hidden" name="qty{{ $key }}" class="form-control" value="{{ old('qty.$key',$data->pivot->qty) }}" id="qty{{ $key }}">
                </td>
                <td>
                  <input type="number" name="price{{ $key }}" class="form-control" value="{{ old('price.$key',$data->pivot->price) }}" onkeyup="calculate(this)" id="price{{ $key }}">
                </td>
                <td>
                  <p class="form-control" id="subTotalShow{{ $key }}">{{ $data->pivot->subtotal }}</p>
                  <input type="hidden" name="price{{ $key }}" class="form-control" value="{{ old('subtotal.$key',$data->pivot->subtotal) }}" id="subtotal{{ $key }}">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
    </div>
  </div>
</form>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
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
