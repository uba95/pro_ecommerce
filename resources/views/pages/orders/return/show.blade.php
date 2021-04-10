@extends('layouts.home')
@section('section')

    <div class="col-8 card">
        <h4 class="card-body-title text-primary p-3">Return Order Details </h4>
        <div class="row">

            <div class="col-md-6">
                @include('pages.orders.return.billing_details')
            </div>

            <div class="col-md-6">
                @include('pages.orders.return.shipping_details', ['request' => $returnOrderRequest])
            </div>
        </div>

        <div class="row mt-4">
            @include('pages.orders.return.product_details')
        </div>
        
        <div class="row mt-4">
            @include('layouts.orders.return_reason')
        </div>

    </div>
@endsection
