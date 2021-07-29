<form method="POST" class="pd-20 pd-sm-40">
    @csrf @method('PATCH')
    @if (!$order->isCancelPending() && !$order->isReturnPending())
      @switch($order->status)
      @case('pending')
      
        <button type="submit" class="btn btn-info pay" formaction="{{ route('admin.orders.update', [$order->id, 'status' => 'paid']) }}">
          Accept Payment
        </button>
        @break
        
      @case('paid')
        <button type="submit" class="btn btn-info ship" formaction="{{ route('admin.orders.update', [$order->id, 'status' => 'shipped']) }}">
          Start Shipping
        </button>
        @break 
      @case('shipped')
        <button type="submit" class="btn btn-info deliver" formaction="{{ route('admin.orders.update', [$order->id, 'status' => 'delivered']) }}">
          Order Is Delivered
        </button>
        @break 
      @case('delivered')
        <strong class="alert alert-success">The Order Is Delivered Successfuly.</strong>
        @break
      @case('canceled')
        <strong class="alert alert-danger ">The Order Is Canceled.</strong>
        @break
      @case('returning')
        <strong class="alert alert-danger">Some Order Items Are In Returning Process.</strong>
        @break
      @case('returned')
        <strong class="alert alert-danger">The Order Is Reurned.</strong>
        @break
      @endswitch

      @if (in_array($order->status, ['pending','paid']))
        <button type="submit" class="btn btn-outline-danger cancel" formaction="{{ route('admin.orders.update', [$order->id, 'status' => 'canceled']) }}">
          Cancel Order
        </button>
      @endif

    @endif

    @if ($order->areSomeItemsCanceled()  && $order->status != 'canceled')
      <strong class="alert alert-danger my-3">Some Order Items Are Canceled.</strong>
    @endif

    @if ($order->areSomeItemsReturned() && $order->status != 'returned')
      <strong class="alert alert-danger my-3">Some Order Items Are Reurned.</strong>
    @endif

    @if ($order->isCancelPending())
      <div class="alert alert-danger my-3"><strong>There Is A Pending Cancel Order Request You Must Resolve It First.</strong></div>
    @endif

    @if ($order->isReturnPending())      
      <div class="alert alert-danger my-3"><strong>There Is A Pending Return Order Request.</strong></div>
    @endif

    @if ($order->cancelOrderRequests->isNotEmpty())      
      <ul class="my-4 p-1 bg-light">
        @foreach ($order->cancelOrderRequests as $key => $request)
            <li class="mg-t-10">
              <a href ='{{ route('admin.cancel_orders.show', $request->id) }}'>Cancel Request {{ $key + 1 }}</a>
              @include('layouts.orders.cancel_order_requst_status')  
            </li>
        @endforeach
     </ul>
    @endif

    @if ($order->returnOrderRequests->isNotEmpty())      
      <ul class="my-4 p-1 bg-light">
        @foreach ($order->returnOrderRequests as $key => $request)
            <li class="mg-t-10">
              <a href ='{{ route('admin.return_orders.show', $request->id) }}'>Return Request {{ $key + 1 }}</a>
              @include('layouts.orders.return_order_request_status')
            </li>
        @endforeach
     </ul>
    @endif


    @if ($errors->any())
    <div class="alert alert-danger mg-t-10">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="mg-t-10"><strong>{{ $error }}</strong></li>
            @endforeach
        </ul>
    </div>
    @endif

</form>
