@extends('layouts.master')
@section('title','Catalogs')
@section('products','active')
@section('catalogs','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Catalogs</li>
@endsection
@section('content')
@can('create', App\Catalog::class)
<div class="row justify-content-between my-3">
  <div class="col-12">
    <a href="{{ route('catalogs.create') }}" class="btn btn-primary">Add Catalog</a>
  </div>
</div>
@endcan
<table id="table" class="table table-hover">
  <thead>
    <tr>
      <th>Name</th>
      <th>Capacity</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($catalog as $data)
      <tr>
        <td>{{ $data->name }}</td>
        <td>{{ $data->capacity }}</td>
        <td>
          @can('viewAny',App\Good::class)
          <a href="{{ route('catalogs.show',$data->id) }}" class="btn btn-primary">Info</a>
          @endcan
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#table').DataTable();
  });
</script>
@endsection
