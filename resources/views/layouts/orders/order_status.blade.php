@switch($order->status)
@case('pending')
    <span class="badge badge-warning">Pending</span>
    @break
@case('paid')
    <span class="badge badge-success">Paid</span>
    @break
@case('shipped')
    <span class="badge badge-info">Shipped</span>
    @break
@case('delivered')
    <span class="badge badge-primary">Delivered</span>
    @break
@case('canceled')
    <span class="badge badge-danger">Canceled</span>
    @break
@case('partiallyCanceled')
    <span class="badge badge-dark">Partially Canceled</span>
    @break
@case('returning')
    <span class="badge badge-danger">Returning</span>
    @break
@case('partiallyReturned')
    <span class="badge badge-dark">Partially Returned</span>
    @break
@case('returned')
    <span class="badge badge-danger">Returned</span>
    @break
@endswitch
