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
<div class="m-3">
  <form action="{{ route('quotation') }}" method="get">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-12">
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Project</label>
          <div class="col-sm-10">
            <select class="form-control" name="project" onchange="getCustomerData(this)">
              <option>Choose Project</option>
              @foreach($project as $data)
                @foreach($data->designers as $datas)
                  @if(count($data->sales) == 0)
                    @if($datas->supervisor_id != null)
                      <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endif
                  @endif
                @endforeach
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
@section('script')
<!-- <script type="text/javascript">
  var i = 1;
  function address() {
    $('#shipTo').val($('#billTo').val());
  }
  function calculateTotal() {
    var total = 0;
    // console.log(total);
    for (var i = 0; i < $('#totalItem').val()+1; i++) {
      total += $('#subtotal'+i).val()*1;
      // console.log($('#subtotal'+i).val()*1);
    }
    $('#totalColumn').html(total);
  }
  function calculate(id) {
    var row = id.name.substring(id.name.length-1,id.name.length);
    // console.log($('#qty'+row).val());
    var subtotal = $('#qty'+row).val()*1 * $('#price'+row).val()*1;
    $('#subtotal'+row).val(subtotal);
    calculateTotal();
  }
  function getCustomerData(name) {
    $.post("{{ route('getCompanyData') }}",{id:name.value,_token:'{{ Session::token() }}'},function(data){
      console.log(data);
      $('#company').html();
      $('#company').val(data[0].name);
      $('#company').attr('readonly','true');
      $('#billTo').html();
      $('#billTo').val(data[0].addresses[0].address);
      $('#billTo').attr('readonly','true');
      $('#shipTo').html();
      $('#shipTo').val(data[0].addresses[0].address);
      $('#phone').html();
      $('#phone').val(data[0].addresses[0].phone);
      $('#phone').attr('readonly','true');
      for (var i = 0; i < data.length; i++) {
        $('#addresses').append('<option value="' + data[i].address + '">');
      }
      $('#phone').val(data.phone);
      getDesignerData(name.value);
    });
  }
  function getDesignerData(id) {
    $.post("{{ route('getDesignerData') }}",{id:id,_token:'{{ Session::token() }}'},function(data){
      console.log(data);
      for (var i = 0; i < data[0].goods.length; i++) {
        console.log(data[0].goods[i].name);
        $('#tableItem').html();
        $('#tableItem').append('<tr><td>' + data[0].goods[i].name + '<input type="hidden" name="item' + i + '" id="item0" value="' + data[0].goods[i].name + '"></td><td>' + data[0].goods[i].pivot.qty + ' ' + data[0].goods[i].units.name + '<input type="hidden" name="qty' + i + '" id="qty0" value="' + data[0].goods[i].pivot.qty + '"><input type="hidden" name="unit' + i + '" id="unit0" value="' + data[0].goods[i].units.name + '"></td><td><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">Rp.</div></div><input type="number" class="form-control" name="price' + i + '" placeholder="1000" onkeyup="calculate(this)" id="price' + i + '"></div></td><td><div class="input-group mb-2"><div class="input-group-prepend"><div class="input-group-text">Rp.</div></div><input type="number" class="form-control" name="subtotal' + i + '" placeholder="1000" id="subtotal' + i + '"></div></td></tr>');
      }
      $('#totalItem').val(i);
    });
  }
</script> -->
@endsection
