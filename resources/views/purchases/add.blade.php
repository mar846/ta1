@extends('layouts.master')
@section('title','Purchase Quotation')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Purchase Quotation</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<form class="m-3" action="{{ route('purchaseQuotation') }}" method="post">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-12">
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Project</label>
        <div class="col-sm-10">
          <select class="form-control" name="project">
            @foreach($project as $data)
              @if(count($data->purchases) == 0)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
              @endif
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <button type="submit" class="btn btn-success col-12" name="button">Search Project</button>
  </div>
</form>
 @endsection
