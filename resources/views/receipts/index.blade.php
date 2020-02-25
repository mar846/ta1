@extends('layouts.master')
@section('title','Receipt')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Receipt</li>
@endsection
@section('content')
<div class="m-3">
  <form action="{{ route('receipts.create') }}" method="get">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-12">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Purchase</label>
          <div class="col-sm-10">
            <select class="form-control" name="id" onchange="getCustomerData(this)">
              <option>Choose Purchase</option>
              @foreach($purchase as $data)
                <option value="{{ $data->id }}">{{ $data->po }}/V{{ $data->version }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    <button type="submit" class="btn btn-success col-12">Search Sale</button>
  </form>
</div>
</div>
@endsection
