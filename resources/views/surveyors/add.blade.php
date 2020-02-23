@extends('layouts.master')
@section('title','Add Survey')
@section('surveyors','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('surveyors.index') }}">Surveys</a></li>
<li class="breadcrumb-item active">Add Survey</li>
@endsection
@section('content')
@if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
@endif
<form action="{{ route('surveyors.store') }}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="inputName">Project Name</label>
        <select class="form-control @error('project') is-invalid @enderror" name="project">
          <option value="#">Choose Project</option>
          @foreach($project as $data)
            @if($data->surveyor == null && $data->status != 'Canceled')
              <option value="{{ $data->id }}">{{ $data->name }}</option>
            @endif
          @endforeach
        </select>
        @error('project')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Question</th>
            <th>Answer</th>
            <th>File</th>
          </tr>
        </thead>
        <tbody>
          @foreach($checklist as $key => $data)
            <tr>
              <td>{{ $data->id }}</td>
              <td>{{ $data->question }}</td>
              <td><input type="text" name="answer{{ $key }}" class="form-control" <?php echo (rand(0,1) == 1)? 'value="yes"':'value="no"'; ?>></td>
              <td><input type="file" name="file{{ $key }}[]" class="form-control" accept="image/*" multiple></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <!-- <div class="form-group d-flex flex-column pt-3">
        <label for="inputFile">File</label>
        <input type="file" name="file" value="{{ old('file') }}" accept="image/jpeg">
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div> -->
      <div class="form-group mt-3">
        <button type="submit" class="btn btn-success col-12" name="button">Submit</button>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</form>
@endsection
