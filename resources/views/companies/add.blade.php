@extends('layouts.master')
@section('title','Add Company')
@section('companies','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
<li class="breadcrumb-item active">Add Company</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<form action="{{ route('companies.store') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
  </div>
  <div class="form-group">
    <label for="name">Type</label>
    <?php $type = ['customer','supplier']; ?>
    <select class="form-control" name="type">
      @foreach($type as $tipe)
        <option value="{{ $tipe }}">{{ ucwords($tipe) }}</option>
      @endforeach
    </select>
  </div>
  <label for="member">Address</label>
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
      <?php for ($i=0; $i < 2; $i++) {
        ?>
        <tr>
          <td>
            <select class="form-control" name="addressName{{ $i }}">
              @foreach($type as $tipe)
                <option value="{{ $tipe }}">{{ $tipe }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="text" name="address{{ $i }}" class="form-control" value="{{ old('address.$key') }}"></td>
          <td><input type="text" name="phone{{ $i }}" class="form-control" value="{{ old('phone.$key') }}"></td>
        </tr>
        <?php
        } ?>
    </tbody>
  </table>
  <div class="form-group row">
    <button type="submit" class="btn btn-success col-12" name="button">Add Company</button>
  </div>
</form>
@endsection
