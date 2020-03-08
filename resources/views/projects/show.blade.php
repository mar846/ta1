@extends('layouts.master')
@section('title','Projects Info')
@section('project','active')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
<li class="breadcrumb-item active">Projects Info</li>
@endsection
@section('content')
@if($project->status != 'Canceled')
  @if($project->status != 'Finish')
  <div class="row justify-content-between">
    <div class="col-2 text-left  mb-2">
      <a href="{{ route('projectFinish',$project->id) }}" class="btn btn-success">Finish</a>
    </div>
    <div class="col-2 text-right  mb-2">
      <a href="{{ route('projects.edit',$project->id) }}" class="btn btn-warning">Edit</a>
    </div>
  </div>
  @endif
@endif
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Project Info</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="inputName">Project Name</label>
          <p class="form-control">{{ $project->name }}</p>
        </div>
        <div class="form-group">
          <label for="inputName">Project Locations</label>
          <p class="form-control">{{ $project->location }}</p>
        </div>
        <div class="form-group">
          <label for="inputName">Project Capacity</label>
          <p class="form-control">{{ $project->capacity }} {{ $project->unit }}</p>
        </div>
        <div class="form-group">
          <label for="inputDescription">Project Description</label>
          <textarea class="form-control-plaintext border rounded" disabled>{{ $project->description }}</textarea>
        </div>
        <div class="form-group">
          <label for="inputDescription">Client</label>
          <div class="border rounded p-3">
            {{ $project->companies->name }} <a href="{{ route('companies.show',$project->companies->id) }}" class="btn btn-info text-white"><i class="fas fa-eye"></i> </a>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Good Receipt</h3>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Batch</th>
              <th>Item</th>
              <th>QTY</th>
              <th>Date</th>
              <th>User</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($project->sales as $data)
              @foreach($data->delivers as $datas)
                @foreach($datas->goods as $datass)
                  <tr>
                    <td>{{ $datas->id }}</td>
                    <td>{{ $datass->name }}</td>
                    <td>{{ $datass->pivot->qty }} {{ $datass->units->name }}</td>
                    <td>{{ date('D, d F Y',strtotime($datass->created_at)) }}</td>
                    <td>{{ ucwords($datas->users->name) }}</td>
                    <td>
                      <a href="{{ route('delivers.show',$datas->id) }}" class="btn btn-info text-white"><i class="fas fa-eye"></i></a>
                    </td>
                  </tr>
                @endforeach
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Good Deliver</h3>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Batch</th>
              <th>Item</th>
              <th>QTY</th>
              <th>Date</th>
              <th>User</th>
            </tr>
          </thead>
          <tbody>
            @foreach($project->purchases as $data)
              @foreach($data->receipts as $datas)
                @foreach($datas->goods as $datass)
                  <tr>
                    <td>{{ $datas->id }}</td>
                    <td>{{ $datass->name }}</td>
                    <td>{{ $datass->pivot->qty }} {{ $datass->units->name }}</td>
                    <td>{{ date('D, d F Y',strtotime($datass->created_at)) }}</td>
                    <td>{{ ucwords($datas->users->name) }}</td>
                  </tr>
                @endforeach
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Designer</h3>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Designers</th>
                  <th>Supervisor</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($project->Designers as $data)
                <tr>
                  <td>{{ $data->users->name }}</td>
                  <td>{{ ($data->supervisor_id != null)?$data->supervisors->name:'' }}</td>
                  <td>{{ date('D, d F Y', strtotime($data->created_at)) }}</td>
                  <td class="alert alert-{{ ($data->supervisor_id == null)?'secondary':'success' }} text-center pt-3"><b>{{ ($data->supervisor_id == null)?'Waiting for Approval':'Finish' }}<b></td>
                  <td><a href="{{ route('designers.show',$data->id) }}" class="btn btn-info text-white"><i class="fas fa-eye"></i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Surveyors</h3>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Surveyors</th>
                  <th>Supervisor</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($project->Surveyors as $data)
                <tr>
                  <td>{{$data->users->name}}</td>
                  <td>{{ ($data->supervisor_id != null)?$data->supervisors->name:'' }}</td>
                  <td>{{ date('D, d F Y', strtotime($data->created_at)) }}</td>
                  <td class="alert alert-{{ ($data->supervisor_id == null)?'secondary':'success' }} text-center pt-3"><b>{{ ($data->supervisor_id == null)?'Waiting for Approval':'Finish' }}<b></td>
                  <td><a href="{{ route('surveyors.show',$data->id) }}" class="btn btn-info text-white"><i class="fas fa-eye"></i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Sales</h3>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($project->sales as $data)
                  <tr>
                    <td>SO-{{ $data->so }}/V{{ $data->version }}</td>
                    <td>{{ $data->users->name }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                      <a href="{{ route('sales.show',$data->id) }}" class="btn btn-info text-white">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Purchases</h3>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>User</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($project->purchases as $data)
                  <tr>
                    <td>PO-{{ $data->po }}</td>
                    <td>{{ $data->users->name }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>
                      <a href="{{ route('purchases.show',$data->id) }}" class="btn btn-info text-white">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Goods</h3>
          </div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>QTY</th>
                  <th>Receipt</th>
                  <th>Delivered</th>
                </tr>
              </thead>
              <tbody>
                @foreach($project->designers as $data)
                  @foreach($data->goods as $datas)
                    <tr>
                      <td>{{ $datas->name }}</td>
                      <td>{{ $datas->pivot->qty }} {{ $datas->units->name }}</td>
                      <?php $array[$datas->id] = 0; ?>
                      @foreach($project->sales as $datass)
                        @foreach($datass->delivers as $datasss)
                          @foreach($datasss->goods as $datassss)
                            @if($datassss->id == $datas->id)
                              <?php
                                if (isset($array[$datassss->id])) {
                                  $array[$datassss->id] += $datassss->pivot->qty;
                                }
                                else {
                                  $array[$datassss->id] = $datassss->pivot->qty;
                                }
                              ?>
                            @endif
                          @endforeach
                        @endforeach
                      @endforeach
                      <td>{{ $array[$datas->id] }} {{ $datas->units->name }}</td>
                      <?php $array[$datas->id] = 0; ?>
                      @foreach($project->purchases as $datass)
                        @foreach($datass->receipts as $datasss)
                          @foreach($datasss->goods as $datassss)
                            @php $array[$datassss->id] = 0; @endphp
                            @if($datassss->id == $datas->id)
                              <?php
                                if (isset($array[$datassss->id])) {
                                  $array[$datassss->id] += $datassss->pivot->qty;
                                }
                                else {
                                  $array[$datassss->id] = $datassss->pivot->qty;
                                }
                              ?>
                            @endif
                          @endforeach
                        @endforeach
                      @endforeach
                      <td>{{ $array[$datas->id] }} {{ $datas->units->name }}</td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Files</h3>
      </div>
      <div class="card-body">
        @foreach($project->files as $data)
        <a href="{{ asset('storage/'.$data->name) }}">
          <div class="card float-left">
            <div class="card-body">
              <i class="fas fa-image" style="font-size:30px;"></i>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
