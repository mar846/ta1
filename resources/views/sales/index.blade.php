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
  <div class="row pb-2">
        @can('create',App\Sale::class)
          <a href="{{ route('sales.create') }}" class="btn btn-primary">Make Quotation</a>
        @endcan
  </div>
  <div class="row">
    <div class="col-12">
      <table class="table table-hover" id="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Bill To</th>
            <th>Ship To</th>
            <th>SO</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sale as $data)
          <tr>
            <td>{{ $data->id }}</td>
            <td>{{ date('D, d F Y', strtotime($data->created_at)) }}</td>
            <td>{{ $data->bills->companies->name }}</td>
            <td>{{ $data->bills->address }}</td>
            <td>{{ $data->ships->address }}</td>
            <td>SO-{{ $data->so }}/R{{ $data->version }}</td>
            <td class="alert alert-{{ ($data->supervisor_id == null)?'secondary':'success' }} pt-3 text-center"><label for="status">{{ ($data->supervisor_id == null)?"Waiting":'Approved' }}</label></td>
            <td>
              @can('view',$data)
              <a href="{{ route('sales.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
              @endcan
              <!-- @can('update',$data)
              <a href="{{ route('sales.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
              @endcan -->
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
