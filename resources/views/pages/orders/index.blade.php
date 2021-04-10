@extends('layouts.home')
@section('section')

<div class="col-8 card">
    <table class="table table-response">
        <thead>
            <tr>
                <th scope="col">Order #</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Total Price</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orders as $key => $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td scope="col">{{ $order->payment_method }} </td>
                    <td scope="col">{{ $order->total_price }}$ </td>
                    <td scope="col">{{ $order->created_at->diffForHumans() }} </td>
                    <td scope="col"> @include('layouts.orders.order_status') </td>
                    <td class="col d-flex">
                        <a class="btn btn-sm btn-info mr-1" href ='{{ route('orders.show', $order->id) }}' title="Show Order" >
                            <i class="fa fa-eye fa-fw"></i>
                        </a>
                        @if (in_array($order->status, ['pending','paid']) && !$order->cancelOrderRequest)
                            <form method="POST" action='{{ route('cancel_orders.store') }}' class="cancelWithoutAjax">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="button" class="btn btn-sm btn-danger" title="Cancel Order">
                                <span class="fa fa-times fa-fw"></span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection