@extends('layouts.app')
@section('title','List Companies')
@section('content')
<div class="">
  <div class="row justify-content-between my-2">
    <h3>List Companies</h3>
    @can('create', App\Company::class)
    <a href="{{ route('companies.create') }}"><button type="button" class="btn btn-success" name="button">Add Companies</button></a>
    @endcan
  </div>
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Address</th>
      <th>Phone</th>
      <th>Type</th>
      <th></th>
    </tr>
    @foreach($company as $data)
      <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->address }}</td>
        <td>{{ $data->phone }}</td>
        <td>{{ ucfirst($data->type) }}</td>
        <td>
          @can('view',$data)
          <a href="{{ route('companies.show',[$data->id]) }}"><button type="button" class="btn btn-secondary" name="button">Info</button></a>
          @endcan
          @can('update',$data)
            <a href="{{ route('companies.edit',[$data->id]) }}"><button type="button" class="btn btn-warning" name="button">Edit</button></a>
          @endcan
        </td>
      </tr>
    @endforeach
  </table>
  <div class="row">
    <div class="col-12 d-flex justify-content-center">
      {{ $company->links() }}
    </div>
  </div>
</div>
@endsection
