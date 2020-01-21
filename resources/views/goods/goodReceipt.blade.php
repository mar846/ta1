@extends('layouts.app')
@section('title','Good Receipt')
@section('content')
<h3>Good Receipt</h3>
<form action="{{ url('goodReceiptSearch') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group row">
   <label class="col-sm-2 col-form-label">Purchase Order</label>
   <div class="col-sm-10">
     <input type="text" name="po" class="form-control @error('po') is-invalid @enderror" id="po" placeholder="Purchase Order" value="{{ old('po') }}">
     @error('po')
         <span class="invalid-feedback" role="alert">
             <strong>{{ $message }}</strong>
         </span>
     @enderror
   </div>
 </div>
   <button type="submit" class="btn btn-success col-sm-10 offset-sm-2" name="button">Search</button>
</form>
@isset($purchase)
<div class="row">
  <h5 class="col-sm-2">Purchase Order</h5>
  <p class="col-sm-10 col-form-label">{{ $purchase->po }}</p>
</div>
<div class="row">
  <h5 class="col-sm-2">Suppllier</h5>
  <p class="col-sm-10 col-form-label">{{ $purchase->addresses->companies->name }}</p>
</div>
<form action="{{ url('goodReceiptFinish') }}" method="post">
  {{ csrf_field() }}
  <table class="table table-hover my-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Item</th>
        <th>QTY</th>
        <th>Receipt</th>
        <th>Memo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($purchase->goods as $key => $data)
      <tr>
        <td>
          {{ $data->id }}
          <input type="hidden" name="item{{ $key }}" value="{{ $data->id }}" readonly>
        </td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
        <td>
          <div class="input-group mb-2 mr-sm-2">
            <input type="text" class="form-control" name="qty{{ $key }}" placeholder="QTY">
            <div class="input-group-prepend">
              <div class="input-group-text">{{ $data->units->name }}</div>
            </div>
          </div>
        </td>
        <td><input type="text" class="form-control" name="memo{{ $key }}"></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <input type="hidden" name="totalItem" value="{{ $key }}">
  <input type="hidden" name="purchaseID" value="{{ $purchase->id }}">
  <button type="submit" class="btn btn-outline-success col-12" name="button">Submit</button>
</form>
@endisset
@endsection
