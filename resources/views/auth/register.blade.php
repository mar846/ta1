@extends('layouts.master')
@section('title','Register')
@section('content')
<div class="card">
  <!-- <div class="card-header">{{ __('Register') }}</div> -->

  <div class="card-body">
      <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" value="123456">

                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

              <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" value="123456">
              </div>
          </div>

          <div class="form-group row">
              <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

              <div class="col-md-6">
                <select class="form-control" name="role" required id="role">
                  <option value="1">Admin</option>
                  <option value="2">Surveyor</option>
                  <option value="3">SurveyorSPV</option>
                  <option value="4">Designer</option>
                  <option value="5">DesignerSPV</option>
                  <option value="6">Sale</option>
                  <option value="7">SaleSPV</option>
                  <option value="8">Purchasing</option>
                  <option value="9">PurchasingSPV</option>
                </select>
                  <!-- <input id="role" type="text" class="form-control" name="role" required autocomplete="role"> -->
              </div>
          </div>

          <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                      {{ __('Register') }}
                  </button>
              </div>
          </div>
      </form>
  </div>
</div>
@endsection
