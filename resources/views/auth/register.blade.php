@extends('layouts.app.index')

@section('content')

<div class="contact_form">
    <div class="container">
        <div class="row">

            <div class="col-lg-5" style="border: 1px solid grey; padding: 20px; border-radius: 25px;margin: 50px auto">
                <div class="contact_form_container">
                    <div class="contact_form_title text-center">Sign Up</div>
                    <form action="{{ route('register') }}" id="contact_form" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" aria-describedby="emailHelp" placeholder="Enter Your Full Name " name="name"
                                required="">
                            @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone') }}" aria-describedby="emailHelp" placeholder="Enter Your Phone "
                                required="">
                            @error('phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter Your Email "
                                required="">
                            @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                aria-describedby="emailHelp" placeholder="Enter Your Password " name="password"
                                required="">
                            @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm Password</label>
                            <input type="password" class="form-control" aria-describedby="emailHelp"
                                placeholder="Re-Type Password " name="password_confirmation" required="">
                        </div>

                        <div class="contact_form_button">
                            <button type="submit" class="btn btn-info">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="panel"></div>
</div>

@endsection