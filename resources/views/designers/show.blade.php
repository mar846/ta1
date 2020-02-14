@extends('layouts.master')
@section('title','Designer Info')
@section('designers','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('designers.index') }}">Designers</a></li>
<li class="breadcrumb-item active">Designers Info</li>
@endsection
@section('content')
<form action="{{ route('designers.store') }}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label>Project</label>
            <p class="form-control">{{ $designer->projects->name }}</p>
        </div>
        <label for="exampleInputFile">Files</label>
        <div class="form-group">
          @foreach($designer->projects->files as $data)
            <div class="card float-left mr-3" style="width: 10rem;">
              <i class="fas fa-file-image col-12 pt-3 pl-4" style="font-size: 130px;"></i>
              <div class="card-body">
                <h5 class="card-text">{{ $data->name }}</h5>
                 <a href="{{ url('storage/'.$data->name) }}" class="btn btn-primary">Preview</a>
              </div>
            </div>
          @endforeach
        </div>
        <div class="form-group">
          <table class="table" id="table">
            <thead>
              <tr>
                <th>Item</th>
                <th>QTY</th>
              </tr>
            </thead>
            <tbody>
              @foreach($designer->goods as $data)
                <tr>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->pivot->qty }} {{ $data->units->name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
  </div>
</form>
@endsection
