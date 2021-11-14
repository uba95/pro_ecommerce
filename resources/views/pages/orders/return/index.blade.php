@extends('layouts.home')

@section('button')
    <a href ='{{ route('return_orders.create') }}' class="btn btn-success mb-3" style="margin-left: -13px;">Add Return Order Request</a>
@endsection

@section('section')

<div class="col-lg-8 card">
    @if (count($return_order_requests))
        
    <table class="table table-responsive d-lg-table">
        <thead>
            <tr>
                <th scope="col">Request Id</th>
                <th scope="col">Order Id</th>
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
                    <td scope="col">{{ $request->created_at->diffForHumans() }} </td>
                    <td scope="col">{{ $request->order->created_at->diffForHumans() }} </td>
                    <td scope="col"> @include('layouts.orders.return_order_request_status') </td>
                    <td scope="col"> @include('layouts.orders.order_status', ['order' => $request->order]) </td>
                    <td class="col d-flex">
                        <div class="dropdown " style="cursor: pointer">
                            <a class="dropdown-button p-4" id="dropdown-menu-{{ $request->id }}" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-menu-{{ $request->id }}">

                                <a class="dropdown-item px-1" href ='{{ route('return_orders.show', $request->id) }}'>
                                    <i class="fa fa-eye fa-fw"></i> Show Request
                                </a>

                                <a class="dropdown-item px-1" href ='{{ route('orders.show', $request->order->id) }}'>
                                    <i class="fa fa-clipboard fa-fw"></i> Show Order
                                </a>
                
                                @if ($request->status == 'pending')
                                    <form method="POST" action='{{ route('return_orders.destroy', $request->id) }}' class="dropdown-item px-1 deleteWithoutAjax">
                                        @csrf @method('DELETE') 
                                        <i class="fa fa-times fa-fw" ></i> Delete Request
                                    </form>
                                @endif
                            </div>
                        </div>
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