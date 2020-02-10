@extends('layouts.master')
@section('title','Checklists')
@section('checklist','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Checklists</li>
@endsection
@section('content')
<div class="row justify-content-between px-3">
  <a href="{{ route('checklists.create') }}" class="btn btn-success">Add</a>
</div>
<div class="row">
  <div class="col-12">
    <table class="table table-hover" id="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Question</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($checklist as $data)
        <tr>
          <td>{{ $data->id }}</td>
          <td>{{ $data->question }}</td>
          <td>
            <a href="{{ route('checklists.edit',$data->id) }}" class="btn btn-warning">Edit</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
@section("script")
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
