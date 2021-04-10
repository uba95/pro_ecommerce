@extends('layouts.home')
@section('section')

<div class="col-8 card">
    @if (count($return_order_requests) > 0)
        
    <table class="table table-response">
        <thead>
            <tr>
                <th scope="col">Request Id</th>
                <th scope="col">Order Id</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Total Price</th>
                <th scope="col">Requset Date</th>
                <th scope="col">Order Date</th>
                <th scope="col">Requset Status</th>
                <th scope="col">Order Status</th>
                <th scope="col">Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($return_order_requests as $key => $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->order->id }}</td>
                    <td scope="col">{{ $request->order->payment_method }} </td>
                    <td scope="col">{{ $request->order->total_price }}$ </td>
                    <td scope="col">{{ $request->created_at->diffForHumans() }} </td>
                    <td scope="col">{{ $request->order->created_at->diffForHumans() }} </td>
                    <td scope="col"> @include('layouts.orders.return_order_request_status') </td>
                    <td scope="col"> @include('layouts.orders.order_status', ['order' => $request->order]) </td>
                    <td class="col d-flex">
                        <a class="btn btn-sm btn-success mr-1" href ='{{ route('return_orders.show', $request->id) }}' title="Show Request" ><i class="fa fa-eye fa-fw"></i></a>
                        <a class="btn btn-sm btn-info mr-1" href ='{{ route('orders.show', $request->order->id) }}' title="Show Order" ><i class="fa fa-eye fa-fw"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @else
    <div class="alert alert-danger mt-5">No Return Order Requests Yet.</div>
    @endif
</div>
@endsection