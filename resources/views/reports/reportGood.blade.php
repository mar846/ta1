@extends('layouts.app')
@section('title','Reports')
@section('content')
<div class="p-3">
  <h3>Reports Goods</h3>
  <div class="card text-center">
    @include('reports.reportLink')
    <div class="card-body">
    <h5 class="card-title">Panel</h5>
    <table class="table table-bordered">
      <tr>
        <th>Item</th>
        <th>Supplier</th>
      </tr>
      @foreach($panel as $i=>$data)
        <tr>
          <td><a href="{{ route('panels.show',$data->id) }}">{{ $data->name }}</a></td>
          <td><a href="{{ route('companies.show',$data->companies->id) }}">{{ $data->companies->name }}</a></td>
        </tr>
      @endforeach
      </table>
      <h5 class="card-title">Inverter</h5>
      <table class="table table-bordered">
        <tr>
          <th>Item</th>
          <th>Supplier</th>
        </tr>
        @foreach($inverter as $i=>$data)
          <tr>
            <td><a href="{{ route('inverters.show',$data->id) }}">{{ $data->name }}</a></td>
            <td><a href="{{ route('companies.show',$data->companies->id) }}">{{ $data->companies->name }}</a></td>
          </tr>
        @endforeach
        </table>
    </div>
  </div>
</div>
@endsection
