@extends('layouts.master')
@section('title','Designer Info')
@section('designers','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('designers.index') }}">Designers</a></li>
<li class="breadcrumb-item active">Designers Info</li>
@endsection
@section('content')
<?php
  $bool = true;
  foreach ($designer->goods as $key => $value) {
    if ($value->pivot->status != 'Approved') {
      $bool = false;
    }
  }
?>
@if($bool != false)
  @can('approve',$designer)
    @if($designer->supervisor_id == null)
      <div class="row justify-content-left px-3 pb-3">
        <a href="{{ route('designerApproval',$designer->id) }}" class="btn btn-primary">Approve</a>
      </div>
      @else
      <div class="row justify-content-left px-3 pb-3">
        <a href="{{ route('designerDisapproval',$designer->id) }}" class="btn btn-warning">Disapprove</a>
      </div>
    @endif
  @endcan
@endif
@if($designer->supervisor_id == null)
  @if($designer->user_id == Auth::user()->id)
    @can('update',$designer)
      <div class="row justify-content-end">
        <div class="col-2 text-right  mb-2">
          <a href="{{ route('designers.edit',$designer->id) }}" class="btn btn-warning">Edit</a>
        </div>
      </div>
    @endcan
  @endif
@endif
<div class="card">
    <div class="card-body">
      <div class="form-group">
        <label>Project</label>
          <p class="form-control">{{ $designer->projects->name }}</p>
      </div>
      <label for="exampleInputFile">Files</label>
      <div class="form-group">
        @foreach($designer->projects->files as $data)
        @if($data->type == 'designer')
          <a href="{{ asset('storage/'.$data->name) }}">
            <div class="card float-left">
              <div class="card-body">
                <i class="fas fa-file" style="font-size:70px;"></i>
              </div>
            </div>
          </a>
          @endif
        @endforeach
      </div>
      <div class="form-group">
        <table class="table" id="table">
          <thead>
            <tr>
              <th>Item</th>
              <th>QTY</th>
              <th>Status</th>
              @can('approval',$designer)
              <th>Action</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach($designer->goods as $key => $data)
              <tr>
                <td>{{ $data->name }}</td>
                <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
                <td class="@if($data->pivot->status == 'waiting') alert alert-secondary @elseif($data->pivot->status == 'Approved') alert alert-success @else alert alert-danger @endif text-center pt-3"><label for="status">{{ $data->pivot->status }}</label></td>
                @can('approval',$designer)
                <td>
                  @if($data->pivot->status === 'waiting')
                    <a href="{{ route('requestApprove',[$designer->id, $data->id]) }}" class="btn btn-success float-left">Approve</a>
                    <form class="form-inline float-left pl-2" action="{{ route('requestDispprove',[$designer->id, $data->id]) }}" method="post">
                      {{ csrf_field() }}
                      <button type="submit" class="btn btn-warning">Reject</button>
                      <input type="text" name="reason{{ $data->id }}" class="@error('reason'.$data->id) is-invalid @enderror" value="{{ old('reason'.$data->id) }}" placeholder="Rejection Reason">
                      @error('reason'.$data->id)
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </form>
                    <!-- <a href="{{ route('requestDispprove',[$designer->id, $data->id]) }}" class="btn btn-warning">Reject</a> -->
                  @endif
                </td>
                @endcan
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
