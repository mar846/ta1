@extends('layouts.master')
@section('title','Sales')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Sales</li>
@endsection
@section('content')
<div class="m-3">
  <div class="row justify-content-between px-3 pb-2">
    @can('create',App\Sale::class)
      <a href="{{ route('sales.create') }}"><button type="button" class="btn btn-success" name="button">Add</button></a>
    @endcan
  </div>
  <table class="table table-hover" id="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Supplier</th>
        <th>SO</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($sale as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ date('D, d F Y', strtotime($data->created_at)) }}</td>
        <td>{{ $data->bills->name }}</td>
        <td>{{ $data->so }}</td>
        <td>
          @can('view',$data)
          <a href="{{ route('sales.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          @endcan
          @can('update',$data)
          <a href="{{ route('sales.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
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
       $('#table').DataTable({
            responsive: true
       });
  });
</script>
@endsection
