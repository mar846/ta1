@extends('layouts.master')
@section('title','Delivery')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Delivery</li>
@endsection
@section('content')
<div class="m-3">
  <form action="{{ route('delivers.create') }}" method="get">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-12">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Sales</label>
          <div class="col-sm-10">
            <select class="form-control" name="id" onchange="getCustomerData(this)">
              <option>Choose Sale</option>
              @foreach($sale as $data)
                @if($data->supervisor_id != null)
                  <option value="{{ $data->id }}">SO-{{ $data->so }}/V{{ $data->version }}</option>
                @endif
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
