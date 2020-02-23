@extends('layouts.master')
@section('title','Edit Company')
@section('companies','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
<li class="breadcrumb-item active">Edit Company</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="px-3">
  <form action="{{ route('companies.update',[$company->id]) }}" method="post">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name',$company->name) }}">
    </div>
    <div class="form-group">
      <label for="name">Type</label>
      <?php $type = ['customer','supplier']; ?>
      <select class="form-control" name="type">
        @foreach($type as $tipe)
          <option value="{{ $tipe }}" @if($tipe == $company->type) selected @endif>{{ ucwords($tipe) }}</option>
        @endforeach
      </select>
    </div>
    <label for="member">Addresses</label>
    <table class="table table-hover" id="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>Phone</th>
        </tr>
      </thead>
      <tbody>
      <?php $type = ['billTo','shipTo']; ?>
        @foreach($company->addresses as $key => $data)
          <tr>
            <td>
              <select class="form-control" name="addressName{{$key}}">
                @foreach($type as $tipe)
                  <option value="{{ $tipe }}" @if($tipe == $data->name) selected @endif>{{ $tipe }}</option>
                @endforeach
              </select>
              <input type="hidden" name="id{{ $key }}" class="form-control" value="{{ $data->id }}">
            </td>
            <td><input type="text" name="address{{ $key }}" class="form-control" value="{{ old('address.$key', $data->address) }}"></td>
            <td><input type="text" name="phone{{ $key }}" class="form-control" value="{{ old('phone.$key', $data->phone) }}"></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="form-group row">
      <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
    </div>
  </form>
</div>
@endsection
