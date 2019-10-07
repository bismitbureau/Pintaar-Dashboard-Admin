@extends('layout/auth/base')

@section('title', 'Sign In')

@section('extra-fonts')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
@endsection

@section('prerender-js')

@endsection

@section('extra-css')

@endsection

@section('content')
  <div class="register-box">
    <div class="register-logo">
      <div><b>Pintaar</b> Dashboard</div>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">Register a new administrator</p>

      <form method="POST" action="{{ route('admin.register.post') }}">
        @csrf
        <div class="form-group has-feedback">
          <input placeholder="Full Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group has-feedback">
          <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group has-feedback">
          <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group has-feedback">
          <input placeholder="Retype Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
      </form>

    </div>
  </div>
@endsection

@section('extra-js')

@endsection
