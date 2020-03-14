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
    <select class="form-control" name="type" onchange="changeAddress(this)">
      @foreach($type as $tipe)
        <option value="{{ $tipe }}">{{ ucwords($tipe) }}</option>
      @endforeach
    </select>
  </div>
  <label for="member">Address</label>
  <table class="table" id="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
      </tr>
    </thead>
    <tbody id="addressTable">
      <?php $type = ['billTo','shipTo']; ?>
      <?php for ($i=0; $i < 2; $i++) {
        ?>
        <tr>
          <td><input type="text" name="addressName{{ $i }}" class="form-control-plaintext border rounded pl-2" value="{{ $type[$i] }}" disabled></td>
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
@section('script')
<script type="text/javascript">
  function changeAddress(param) {
    if (param.value == "customer") {
      $('#addressTable').html("");
      $('#addressTable').append('<tr><td><p class="form-control">billTo</p><input type="hidden" name="addressName0" value="billTo" disabled></td><td><input type="text" name="address0" class="form-control" value="{{ old('address0') }}"></td><td><input type="text" name="phone0" class="form-control" value="{{ old('phone0') }}"></td></tr><tr><td><p class="form-control">shipTo</p><input type="hidden" name="addressName1" value="shipTo"></td><td><input type="text" name="address1" class="form-control" value="{{ old('address1') }}"></td><td><input type="text" name="phone1" class="form-control" value="{{ old('phone1') }}"></td></tr>');
    }
    else {
      $('#addressTable').html("");
      $('#addressTable').append('<tr><td><p class="form-control">billTo</p><input type="hidden" name="addressName0" value="billTo"></td><td><input type="text" name="address0" class="form-control" value="{{ old('address0') }}"></td><td><input type="text" name="phone0" class="form-control" value="{{ old('phone0') }}"></td></tr>');
    }
  }
</script>
@endsection
