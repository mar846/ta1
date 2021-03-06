@extends('layouts.master')
@section('title','Purchases')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Purchases</li>
@endsection
@section('content')
<div class="m-3">
  <!-- <div class="row justify-content-between px-3 pb-2">
    @can('create',App\Purchase::class)
      <a href="{{ route('purchases.create') }}" class="btn btn-primary">Make Quotation</a>
      <a href="{{ route('purchaseRequest') }}" class="btn btn-primary">Purchase Request</a>
    @endcan
  </div> -->
  <table class="table" id="table">
    <tr>
      <th>ID</th>
      <th>Item</th>
      <th>QTY</th>
      <th>Project</th>
      <th>Action</th>
    </tr>
    @foreach($designer as $data)
      @foreach($data->goods as $datas)
      <tr>
        <td>{{ $datas->id }}</td>
        <td>{{ $datas->name }}</td>
        <td>{{ $datas->pivot->qty }} {{ $datas->units->name }}</td>
        <td>{{ $data->projects->name }}</td>
        <td>
          <a href="#" class="btn btn-success">Order</a>
          <!-- @can('view',$data)
          <a href="{{ route('purchases.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          @endcan -->
          <!-- <a href="{{ route('purchases.edit',[$data->id]) }}"><button type="button" class="btn btn-warnning" name="button">Edit</button></a> -->
        </td>
      </tr>
      @endforeach
    @endforeach
  </table>
</div>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
