@extends('layouts.app.index')

@section('content')

<div class="contact_form">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 py-5 px-3" style="border: 1px solid grey; border-radius: 25px;margin: 50px auto">
                <div class="contact_form_container">
                    <div class="contact_form_title text-center">Sign In</div>
                    <form action="{{ route('login') }}" id="contact_form" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email or Phone</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" aria-describedby="emailHelp" required="">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                aria-describedby="emailHelp" name="password" required="">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('password.request') }}" class="my-3">I forgot my password</a>

                        <div class="contact_form_button mt-4">
                            <button type="submit" class="btn btn-info">Login</button>
                        </div>
                    </form>
                    <br>
                    <hr>
                    <br>
                    <a href ='{{ route('loginWith', 'facebook') }}' class="btn btn-primary btn-block">
                        <i class="fab fa-facebook-square"></i> 
                        Login with Facebook
                    </a>
                    <a href ='{{ route('loginWith', 'google') }}' class="btn btn-danger btn-block">
                        <i class="fab fa-google"></i> 
                        Login with Google
                    </a>

                     <div class="mt-4"><span>Don't have an account? <a href ='{{ route('register') }}'>Sign up</a></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel"></div>
</div>
@endsection