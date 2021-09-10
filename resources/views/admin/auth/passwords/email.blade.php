@extends('layouts.admin.index')

@section('admin_content')
    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Ecommmerce <span class="tx-info tx-normal">Admin</span></div>
            <div class="tx-center mg-b-60">{{ __('Admin Reset Password') }}</div>
            <form action="{{ route('admin.password.email') }}" method="POST">
                @csrf         
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                </div><!-- form-group -->
                @error('email')
                    <span class="invalid-feedback d-block mb-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="btn btn-info btn-block">{{ __('Send Password Reset Link') }}</button>
            </form>    
        </div><!-- login-wrapper -->
    </div><!-- d-flex --> 
@endsection
