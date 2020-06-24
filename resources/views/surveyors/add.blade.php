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
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('surveyors.store') }}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="inputName">Project Name</label>
        <select class="form-control @error('project') is-invalid @enderror" name="project" onchange="status(this)">
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
      <table class="table table-hover">
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
              <td>
                <textarea name="answer{{ $key }}" class="form-control @error('answer'.$key) is-invalid @enderror" rows="3" cols="80">{{ (rand(0,1) == 1)? 'yes':'no' }}</textarea>
                @error('answer'.$key)
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </td>
              <td><input type="file" name="file{{ $key }}[]" accept="image/*" multiple></td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="form-group mt-3">
        <button type="submit" class="btn btn-success col-12" id="btnSubmit" disabled name="button">Submit</button>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
</form>
@endsection
@section('script')
  <script type="text/javascript">
      function status(id) {
        if (id.value === '#') {
          $("#btnSubmit").prop('disabled', true);
        }
        else {
          $("#btnSubmit").prop('disabled', false);
        }
      }
  </script>
@endsection
