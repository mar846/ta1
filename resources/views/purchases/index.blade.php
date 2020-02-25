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
  <div class="row justify-content-between px-3 pb-2">
    @can('create',App\Purchase::class)
      <a href="{{ route('purchases.create') }}" class="btn btn-primary">Make Quotation</a>
      <!-- <a href="{{ route('purchaseRequest') }}" class="btn btn-primary">Purchase Request</a> -->
    @endcan
  </div>
  <table class="table table-hover" id="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Item</th>
        <th>QTY</th>
        <th>Project</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($purchase as $data)
        <tr>
          <td>{{ $data->id }}</td>
          <td>{{ date('D, d F Y', strtotime($data->created_at)) }}</td>
          <td>{{ $data->addresses->companies->name }}</td>
          <td>{{ $data->po }}</td>
          <td>
            @can('view',$data)
            <a href="{{ route('purchases.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
            @endcan
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
