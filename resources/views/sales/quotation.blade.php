@extends('layouts.master')
@section('title','Sale Quotation')
@section('order','active')
@section('sale','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
<li class="breadcrumb-item active">Add Sale</li>
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('sales.store') }}" method="post">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-md-6">
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Project</label>
        <div class="col-sm-9">
          <input type="hidden" name="project" value="{{ old('project',$project->id) }}">
          <p class="form-control">{{ $project->name }}</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Customer</label>
        <div class="col-sm-9">
          <input type="hidden" name="company" value="{{ old('company',$project->companies->name) }}">
          <p class="form-control">{{ $project->companies->name }}</p>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Bill To</label>
        <div class="col-sm-9">
          @foreach($project->companies->addresses as $data)
            @if($data->name == 'billTo')
            <p class="form-control">{{ $data->address }}</p>
            <input type="hidden" name="billTo" value="{{ old('billTo',$data->address) }}">
            @endif
          @endforeach
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Ship To</label>
        <div class="col-sm-9">
          @foreach($project->companies->addresses as $data)
            @if($data->name == 'shipTo')
            <p class="form-control">{{ $data->address }}</p>
            <input type="hidden" name="shipTo" value="{{ old('shipTo',$data->address) }}">
            @break
            @endif
          @endforeach
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Phone</label>
        <div class="col-sm-9">
          <p class="form-control">
            @foreach($project->companies->addresses as $data)
              @if($data->name == 'billTo')
                {{ $data->phone }}
                @php
                $phone = $data->phone;
                @endphp
                @break
              @endif
            @endforeach
          </p>
          <input type="hidden" name="phone" value="{{ old('phone') }}">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Valid Till</label>
        <div class="col-sm-9">
          <input type="date" class="form-control @error('validTill') is-invalid @enderror" name="validTill" value="{{ old('validTill', date('Y-m-d',time()+2592000)) }}" min="{{ date('Y-m-d',time()) }}" max="{{ date('Y-m-d',(time()+5184000)) }}">
          @error('validTill')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div> -->
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Reference</label>
        <div class="col-sm-9">
          <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" value="{{ old('reference') }}">
          @error('reference')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Reference Date</label>
        <div class="col-sm-9">
          <input type="date" class="form-control @error('referenceDate') is-invalid @enderror" name="referenceDate" placeholder="dd-mm-yyyy" value="{{ old('referenceDate') }}">
          @error('referenceDate')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Payment Terms</label>
        <div class="col-sm-9">
          <?php for ($i=0; $i < 3; $i++) {?>
            <div class="row">
              <div class="col-sm-12">
               <div class="input-group">
                 <input type="number" name="percentage{{ $i }}" class="form-control @error('percentage'.$i) is-invalid @enderror" placeholder="10" value="{{ old('percentage'.$i) }}">
                 @error('percentage.$i')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
                 <div class="input-group-prepend">
                   <div class="input-group-text">%</div>
                 </div>
                 <input type="text" name="description{{ $i }}" class="form-control @error('description'.$i) is-invalid @enderror" placeholder="description" value="{{ old('description'.$i) }}">
                 @error('description.$i')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                 @enderror
               </div>
             </div>
            </div>
          <?php } ?>
          <button type="button" class="btn btn-secondary btn-sm col-12" name="button">Add Terms</button>
          <!-- <textarea name="paymentTerms" class="form-control @error('paymentTerms') is-invalid @enderror" rows="3" cols="80">{{ old('paymentTerms','DP 50% pada saat surat order diterima SIsa 50% pada saat barang diambil') }}</textarea> -->
          <!-- <input type="text" class="form-control @error('paymentTerms') is-invalid @enderror" name="paymentTerms" value="{{ old('paymentTerms','DP 50% pada saat surat order diterima SIsa 50% pada saat barang diambil') }}"> -->

        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">Delivery Time</label>
        <div class="col-sm-9">
          <input type="text" class="form-control @error('deliveryTime') is-invalid @enderror" name="deliveryTime" value="{{ old('deliveryTime', '4 - 5 bulan setelah terima DP') }}">
          @error('deliveryTime')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($project->designers as $data)
        @foreach($data->goods as $key => $datas)
          <tr>
            <td>
              {{ $datas->name }}
              <input type="hidden" name="item{{ $key }}" value="{{ old('item.$key',$datas->name) }}">
            </td>
            <td>
              {{ $datas->pivot->qty }} {{ $datas->units->name }}
              <input type="hidden" name="qty{{ $key }}" value="{{ old('qty.$key',$datas->pivot->qty) }}" id="qty{{ $key }}">
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <input type="number" class="form-control @error('price.$key') is-invalid @enderror" name="price{{ $key }}" placeholder="1000" onkeyup="calculate(this)" id="price{{ $key }}" value="{{ old('price.$key',($datas->price * $datas->profit)) }}">
                @error('price.$key')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </td>
            <td>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp.</div>
                </div>
                <p class="form-control" id="subTotalShow{{$key}}">{{ $datas->pivot->qty * $datas->price * $datas->profit }}</p>
                <input type="hidden" class="form-control" name="subtotal{{ $key }}" placeholder="1000" onkeyup="calculate(this)" id="subtotal{{ $key }}" value="{{ old('subtotal.$key',($datas->pivot->qty * $datas->price * $datas->profit)) }}">
              </div>
            </td>
          </tr>
        @endforeach
        @break
      @endforeach
    </tbody>
  </table>
  <hr>
  <div class="form-group row">
    <input type="hidden" name="totalItem" value="{{ $key }}">
    <input type="hidden" name="totalTerm" value="{{ $i }}">
    <button type="submit" class="btn btn-success col-12" name="button">Make Quotation</button>
  </div>
</form>
@endsection
@section('script')
<script type="text/javascript">
  function calculate(id) {
    var row = id.name.substring(id.name.length-1,id.name.length);
    // console.log($('#qty'+row).val());
    var subtotal = $('#qty'+row).val()*1 * $('#price'+row).val()*1;
    $('#subtotal'+row).val(subtotal);
    $('#subTotalShow'+row).html('');
    $('#subTotalShow'+row).html(subtotal);
  }
</script>
@endsection
