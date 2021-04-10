@extends('layouts.app')
@section('content')

    <div class="contact_form">
        <div class="container">
            @if (Route::currentRouteName() == 'addresses.index')
                <a href ='{{ route('addresses.create') }}' class="btn btn-success mb-3" style="margin-left: -13px;">Add New Address</a>
            @endif
            @if (Route::currentRouteName() == 'return_orders.index')
                <a href ='{{ route('return_orders.create') }}' class="btn btn-success mb-3" style="margin-left: -13px;">Add Return Order Request</a>
            @endif
            <div class="row">

                @yield('section')

                <div class="col-4">
                    <div class="card">

                        <img src="{{ asset('public/frontend/images/kaziariyan.png') }}" class="card-img-top"
                            style="height: 90px; width: 90px; margin-left: 34%;">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ Auth::user()->name }}</h5>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <a href="{{ route('password.change') }}">Change Password</a>
                            </li>
                            <li class="list-group-item"> <a href="{{ route('addresses.index') }}">Addresses</a> </li>
                            <li class="list-group-item"> <a href="{{ route('orders.index') }}">Orders</a> </li>
                            <li class="list-group-item"> <a href="{{ route('cancel_orders.index') }}">Cancel Order Requests</a> </li>
                            <li class="list-group-item"> <a href="{{ route('return_orders.index') }}">Return Order Requests</a> </li>
                            <li class="list-group-item">Edit Profile</li>
                            <li class="list-group-item"><a href=""> Return Order</a> </li>
                        </ul>

                        <div class="card-body">
                            <a href="{{ route('user.logout') }}" class="btn btn-danger btn-sm btn-block">Logout</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
