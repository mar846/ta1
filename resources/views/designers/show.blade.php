@extends('layouts.master')
@section('title','Designer Info')
@section('designers','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('designers.index') }}">Designers</a></li>
<li class="breadcrumb-item active">Designers Info</li>
@endsection
@section('content')
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
@endif
@if($designer->user_id == Auth::user()->id)
  @can('update',$designer)
    <div class="row justify-content-end">
      <div class="col-2 text-right  mb-2">
        <a href="{{ route('designers.edit',$designer->id) }}" class="btn btn-warning">Edit</a>
      </div>
    </div>
@endcan
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
          <div class="card float-left mr-3" style="width: 10rem;">
            <i class="fas fa-file-image col-12 pt-3 pl-4" style="font-size: 130px;"></i>
            <div class="card-body">
              <h5 class="card-text">{{ $data->name }}</h5>
               <a href="{{ url('storage/'.$data->name) }}" class="btn btn-primary">Preview</a>
            </div>
          </div>
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
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($designer->goods as $data)
              <tr>
                <td>{{ $data->name }}</td>
                <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
                <td class="@if($data->pivot->status == 'waiting') alert alert-secondary @elseif($data->pivot->status == 'Approved') alert alert-success @elseif($data->pivot->status == 'Rejected') alert alert-danger @endif text-center pt-3"><label for="status">{{ $data->pivot->status }}</label></td>
                <td>
                  @if($data->pivot->status === 'waiting')
                    <a href="{{ route('requestApprove',[$designer->id, $data->id]) }}" class="btn btn-success">Approve</a>
                    <a href="{{ route('requestDispprove',[$designer->id, $data->id]) }}" class="btn btn-warning">Reject</a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
