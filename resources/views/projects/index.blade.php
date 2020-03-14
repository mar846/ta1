@extends('layouts.master')
@section('title','Projects')
@section('project','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item active">Projects</li>
@endsection
@section('content')
<div class="m-3">
  <div class="row pb-2">
      @can('create',App\Project::class)
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Make Project</a>
      @endcan
  </div>
  <div class="row">
    <div class="col-12">
      <table class="table table-hover" id="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Capacity</th>
            <th>Client</th>
            <th>Location</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($project as $data)
            <tr>
              <td>{{ $data->id }}</td>
              <td>{{ $data->name }}</td>
              <td>{{ $data->capacity }} {{ $data->unit }}</td>
              <td>{{ $data->companies->name }}</td>
              <td>{{ $data->location }}</td>
              @if($data->status == 'On Progress')
                @php $status = 'alert alert-secondary'; @endphp
              @elseif($data->status == 'Finish')
                @php $status = 'alert alert-success'; @endphp
              @else
                @php $status = 'alert alert-danger'; @endphp
              @endif
              <td class="{{ $status }} text-center pt-3"><b>{{ $data->status }}<b></td>
              <td>
                <a href="{{ route('projects.show',$data->id) }}" class="btn btn-secondary">Info</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
       $('#table').DataTable();
  });
</script>
@endsection
