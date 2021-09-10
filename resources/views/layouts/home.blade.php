@extends('layouts.app.index')
@section('content')

    <div class="contact_form">
        <div class="container py-4">

            @yield('button')

            <div class="row">

                @yield('section')

                <div class="col-lg-4 my-5 my-lg-0">
                    <div class="card">

                        <img referrerpolicy="no-referrer" src="{{ current_user()->avatar }}" class="card-img-top"
                            style="height: 90px; width: 90px;margin: 10px auto">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ current_user()->name }}</h5>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <a href="{{ route('home') }}">Home</a></li>
                            @if (!empty(current_user()->getOriginal('password')))
                                <li class="list-group-item"> <a href="{{ route('home.password') }}">Change Password</a></li>
                            @endif
                            <li class="list-group-item"> <a href="{{ route('addresses.index') }}">Addresses</a> </li>
                            <li class="list-group-item"> <a href="{{ route('orders.index') }}">Orders</a> </li>
                            <li class="list-group-item"> <a href="{{ route('cancel_orders.index') }}">Cancel Order Requests</a> </li>
                            <li class="list-group-item"> <a href="{{ route('return_orders.index') }}">Return Order Requests</a> </li>
                        </ul>

                        <div class="card-body">
                            <form action="{{ route('logout') }}" method="POST"> @csrf
                                <button class="btn btn-outline-danger btn-sm btn-block">Logout</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
