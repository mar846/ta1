@extends('layouts.master')
@section('title','Purchase Add')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
<li class="breadcrumb-item active">Purchase Add</li>
@endsection
@section('content')
@if ($errors->any())
  @foreach ($errors->all() as $error)
      <div class="alert alert-danger">{{ $error }}</div>
  @endforeach
@endif
<div class="m-3">
  <form action="{{ route('purchaseQuotation') }}" method="get">
    {{ csrf_field() }}
    <div class="form-group">
      <label class="col-sm-2 col-form-label">Project</label>
      <div class="col-sm-12">
        <select class="form-control" name="project">
          <option>Choose Project</option>
          @foreach($project as $data)
            @foreach($data->designers as $datas)
              @if($datas->supervisor_id != null)
                <option value="{{ $data->id }}">{{ $data->name }}</option>
              @endif
            @endforeach
          @endforeach
        </select>
        @error('company')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <button type="submit" name="button" class="btn btn-success col-12">Search Project</button>
    </div>
  </form>
</div>
@endsection
@section('script')
  <script type="text/javascript">
    function calculate(id) {
      var row = id.name.substring(id.name.length-1,id.name.length);
      console.log(row);
      $('#subtotal'+row).val($('#qty'+row).val()*$('#price'+row).val());
    }
    function getSupplierData(name) {
      $.post("{{ route('getCompanyData') }}",{name:name.value,_token:'{{ Session::token() }}'},function(data){
        $('#addresses').html();
        for (var i = 0; i < data.length; i++) {
          $('#addresses').append('<option value="' + data[i].address + '">');
        }
        $('#phone').val(data.phone);
      });
    }
  </script>
@endsection
