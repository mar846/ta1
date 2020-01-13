@extends('layouts.app')
@section('title','Purchase Add')
@section('content')
<div class="m-3">
  <h3 class="mb-3">Purchase Add</h3>
  <form action="{{ route('purchases.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Supplier</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="supplier" list="dataSupplier">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
            <textarea name="address" class="form-control" rows="8" cols="80"></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Phone</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="phone">
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="reference" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Reference Date</label>
          <div class="col-sm-10">
            <input type="data" class="form-control" name="referenceDate" placeholder="dd-mm-yyyy">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Sales Reference</label>
          <div class="col-sm-10">
            <select class="form-control" name="">
              <?php
                for ($i=0; $i < 10; $i++) {
                  ?>
                  <option value=""><?php echo $i ?></option>
                  <?php
                }
              ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-bordered">
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
        <th></th>
      </tr>
      <?php
        for ($i=0; $i < 11; $i++) {
          ?>
          <tr>
            <td><input type="text" name="" class="form-control" value=""></td>
            <td>
              <div class="input-group mb-2">
                <input type="number" class="form-control" name="qty" placeholder="1">
                <div class="input-group-prepend">
                  <div class="input-group-text">pcs</div>
                </div>
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" class="form-control" name="price" placeholder="1000">
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" class="form-control" name="price" placeholder="1000">
              </div>
            </td>
            <td><button type="button" class="btn btn-danger btn-sm" name="button">X</button></td>
          </tr>
          <?php
        }
      ?>
    </table>
  </form>
</div>
<datalist id="dataSupplier">
  @foreach($company as $data)
  <option value="{{ $data->name }}">
  @endforeach
</datalist>
@endsection
