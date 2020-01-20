@extends('layouts.app')
@section('title','Bill of materials')
@section('content')
<div class="row justify-content-between p-4">
  <h3>Bill Of Materials</h3>
  <a href="{{ route('bills.create') }}" class="btn btn-success">Add</a>
</div>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($bill as $data)
    <tr>
      <td>{{ $data->id }}</td>
      <td>{{ $data->name }}</td>
      <td>
        <a href="{{ route('bills.show',$data->id) }}" class="btn btn-secondary">Info</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
