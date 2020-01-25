@extends('layouts.app')
@section('title','Checklist')
@section('content')
<div class="row justify-content-between px-3">
  <h3>Checklist</h3>
  <a href="{{ route('checklists.create') }}" class="btn btn-success">Add</a>
</div>
<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Question</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>
@endsection
