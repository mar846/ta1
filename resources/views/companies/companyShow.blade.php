@extends('layouts.app')
@section('title','Show Company')
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="">
  <div class="row justify-content-between">
    <h3>Show Company</h3>
    <a href="{{ route('companies.edit',[$company->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Name</label>
    <label>{{ $company->name }}</label>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Address</label>
    <label>{{ $company->address }}</label>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Phone</label>
    <label>{{ $company->phone }}</label>
  </div>
  <h5>Panels</h5>
  <table class="table">
    <tr>
      <th>Name</th>
      <th>Maximum Power</th>
    </tr>
    @foreach($company->panels as $data)
    <tr>
      <td><a href="{{ route('panels.show',[$data->id]) }}">{{ $data->name }}</a></td>
      <td>{{ $data->Pmax }} W</td>
    </tr>
    @endforeach
  </table>
  <h5>Inverters</h5>
  <table class="table">
    <tr>
      <th>Name</th>
      <th>Nominal Output Power</th>
    </tr>
    @foreach($company->inverters as $data)
    <tr>
      <td><a href="{{ route('inverters.show',[$data->id]) }}">{{ $data->name }}</a></td>
      <td>{{ $data->nominalOutputPower }} kW</td>
    </tr>
    @endforeach
  </table>
</div>
@endsection
