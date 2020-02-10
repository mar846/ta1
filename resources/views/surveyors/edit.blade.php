@extends('layouts.master')
@section('title','Surveyors Edit')
@section('surveyors','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('surveyors.index') }}">Surveyors</a></li>
<li class="breadcrumb-item active">Surveyors Edit</li>
@endsection
@section('content')
<form action="{{ route('surveyors.update',$surveyor->id) }}" method="post">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="inputName">Project Name</label>
        <select class="form-control" name="project">
          <option value="#">Choose Project</option>
          @foreach($project as $data)
            <option value="{{ $data->id }}" @if($data->id == $surveyor->project_id) selected @endif>{{ $data->name }}</option>
          @endforeach
        </select>
      </div>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Question</th>
            <th>Answer</th>
          </tr>
        </thead>
        <tbody>
          @foreach($surveyor->checklists as $key => $data)
            <tr>
              <td>{{ $data->id }}</td>
              <td>{{ $data->question }}</td>
              <td><input type="text" name="answer{{ $key }}" class="form-control" value="{{ old('answer.$key', $data->pivot->answer) }}"></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="row">
        <button type="submit" class="btn btn-warning col-12" name="button">Update</button>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</form>
@endsection
