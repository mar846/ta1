@extends('layouts.app')
@section('reportLink','warehouse')
@section('title','Reports')
@section('content')
<div class="p-3">
  <h3>Reports Warehouse</h3>
  <div class="card text-center">
    @include('reports.reportLink',['page'=>'warehouse'])
    <div class="card-body">
      @foreach($warehouse as $i=>$data)
        @if($i!=0)
        <hr class="py-3">
        @endif
        <h5 class="card-title">Warehouse {{ $data->name }}</h5>
        <table class="table table-bordered">
          <tr>
            <th>Item</th>
            <th>Supplier</th>
            <th>QTY</th>
          </tr>
          <tr>
            <th colspan="3" class="bg-light">Panels</th>
          </tr>
          @foreach($data->panels as $i=>$panel)
            <tr>
              <td><a href="{{ route('panels.show',[$panel->id]) }}">{{ $panel->name }}</a></td>
              <td><a href="{{ route('companies.show',[$panel->companies->id]) }}">{{ $panel->companies->name }}</a></td>
              <td>{{ $panel->pivot->qty }} pcs</td>
            </tr>
          @endforeach
          <tr>
            <th colspan="3" class="bg-light">Inverter</th>
          </tr>
          @foreach($data->inverters as $i=>$inverter)
            <tr>
              <td><a href="{{ route('inverters.show',[$inverter->id]) }}">{{ $inverter->name }}</a></td>
              <td><a href="{{ route('companies.show',[$inverter->companies->id]) }}">{{ $inverter->companies->name }}</a></td>
              <td>{{ $inverter->pivot->qty }} pcs</td>
            </tr>
          @endforeach
        </table>
      @endforeach
    </div>
  </div>
</div>
@endsection
