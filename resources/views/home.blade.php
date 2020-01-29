@extends('layouts.master')
@section('home','active')
@section('content')
<img src="logo.svg" alt="logo" style="width:50%; position: absolute; top:  30%; left: 30%; opacity:.4;">
<!-- <div class="row justtify-content-center">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">Dashboard</div>
      <div class="card-body">
        @if(session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif

        You are logged in!
      </div>
    </div>
  </div>
</div> -->
@endsection
