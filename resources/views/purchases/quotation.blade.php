@extends('layouts.master')
@section('title','Purchase Quotation')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Add Purchase</li>
@endsection
@section('content')
<?php $purchase = array(); ?>
@foreach($project->purchases as $purchase)
@endforeach
@foreach($dataPurchase as $test)
  <?php $purchase[$test->company_id] = 'test' ?>
@endforeach
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
    <div class="col-md-12">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Project</label>
        <div class="col-sm-10">
          <p class="form-control">{{ $project->name }}</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
          <textarea class="form-control">{{ $project->description }}</textarea>
        </div>
      </div>
    </div>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Supplier</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($project->designers as $data)
        @foreach($data->goods as $key => $datas)
          <tr>
            <td>
              {{ $datas->name }}
              <input type="hidden" name="item{{ $key }}" value="{{ old('item.$key',$datas->name) }}">
            </td>
            <td>
              {{ $datas->pivot->qty }} {{ $datas->units->name }}
              <input type="hidden" name="qty{{ $key }}" value="{{ old('qty.$key',$datas->pivot->qty) }}" id="qty{{ $key }}">
            </td>
            <td>
              {{ ($datas->companies != null) ? $datas->companies->name : '' }}
            </td>
            <td>
              @if(count($project->purchases) > 0)
                @isset($purchase[$datas->company_id])
                  <a href="{{ route('purchases.show',[$purchase->id]) }}" class="btn btn-success">View Purchase</a>
                @endisset
                @empty($purchase[$datas->company_id])
                  @isset($datas->companies)
                    <a href="{{ route('addPurchaseQuotation',[$project->id,$datas->company_id,$datas->id]) }}" class="btn btn-primary">Make Purchase</a>
                  @endisset
                @endempty
                @empty($datas->companies)
                <a href="{{ route('addPurchaseQuotation',[$project->id,'new',$datas->id]) }}" class="btn btn-primary">Make Purchase</a>
                @endempty
              @else
                @isset($datas->companies)
                  <a href="{{ route('addPurchaseQuotation',[$project->id,$datas->company_id,$datas->id]) }}" class="btn btn-primary">Make Purchase</a>
                @endisset
                @empty($datas->companies)
                  <a href="{{ route('addPurchaseQuotation',[$project->id,'new',$datas->id]) }}" class="btn btn-primary">Make Purchase</a>
                @endempty
              @endif
          </tr>
        @endforeach
        @break
      @endforeach
    </tbody>
  </table>
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
