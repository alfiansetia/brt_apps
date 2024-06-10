@extends('layouts.auth', ['title' => 'Login'])

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="nrp">NRP</label>
                    <input id="nrp" type="text" class="form-control @error('nrp') is-invalid @enderror"
                        name="nrp" tabindex="1" placeholder="Please Input NRP" value="{{ old('nrp') }}" required
                        autofocus>
                    @error('nrp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        Please fill in your NRP
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label @error('password') is-invalid @enderror">Password</label>
                        {{-- <div class="float-right">
                            <a href="auth-forgot-password.html" class="text-small">
                                Forgot Password?
                            </a>
                        </div> --}}
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2"
                        placeholder="Please Input Password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="invalid-feedback">
                        Please fill in your Password
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>
            {{-- <div class="text-center mt-4 mb-3">
            <div class="text-job text-muted">Login With Social</div>
        </div>
        <div class="row sm-gutters">
            <div class="col-6">
                <a class="btn btn-block btn-social btn-facebook">
                    <span class="fab fa-facebook"></span> Facebook
                </a>
            </div>
            <div class="col-6">
                <a class="btn btn-block btn-social btn-twitter">
                    <span class="fab fa-twitter"></span> Twitter
                </a>
            </div>
        </div> --}}

        </div>
    </div>
@endsection
