@extends('layouts.master')
@section('title','Purchase Request')
@section('order','active')
@section('purchase','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchase</a></li>
<li class="breadcrumb-item active">Purchase Request</li>
@endsection
@section('content')
<div class="form-group row">
  <table class="table table-hover" id="table">
    <thead>
      <tr>
        <th>Item</th>
        <th>QTY</th>
        <th>Project Name</th>
        <th>Designer</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($designer as $data)
        @if($data->supervisor_id == null)
          @foreach($data->goods as $datas)
            <tr>
              <td>{{ $datas->name }}</td>
              <td>{{ $datas->pivot->qty }} {{ $datas->units->name }}</td>
              <td>{{ $data->projects->name }}</td>
              <td>{{ $data->users->name }}</td>
              <td class="@if($datas->pivot->status == 'waiting') alert alert-secondary @elseif($datas->pivot->status == 'Approved') alert alert-success @elseif($datas->pivot->status == 'Rejected') alert alert-danger @endif text-center pt-3"><label for="status">{{ $datas->pivot->status }}</label></td>
              <td>
                @if($datas->pivot->status === 'waiting')
                  <a href="{{ route('requestApprove',[$data->id, $datas->id]) }}" class="btn btn-success">Approve</a>
                  <a href="{{ route('requestDispprove',[$data->id, $datas->id]) }}" class="btn btn-warning">Reject</a>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
      @endforeach
    </tbody>
  </table>
</div>
@endsection
@section('script')
@endsection
