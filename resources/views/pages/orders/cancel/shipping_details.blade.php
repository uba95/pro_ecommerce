<div class="card">
    <h6 class="card-header">Shipping Details</h6>
    <div class="card-body">
      <table class="table">

        @if ($cancelOrderRequest->shippingAddress)
          <tr>
            <th> Phone: </th>
            <th> {{  $cancelOrderRequest->shippingAddress->phone }} </th>
          </tr>

          <tr>
            <th> Address1: </th>
            <th> {{  $cancelOrderRequest->shippingAddress->address_1 }} </th>
          </tr>

          <tr>
            <th> Address2: </th>
            <th> {{  $cancelOrderRequest->shippingAddress->address_2 }} </th>
          </tr>

          <tr>
            <th> City : </th>
            <th> {{  $cancelOrderRequest->shippingAddress->city }} </th>
          </tr>

          <tr>
            <th> Country : </th>
            <th> {{  $cancelOrderRequest->shippingAddress->country->name }} </th>
          </tr>
        @endif

        <tr>
          <th>Request Status: </th>
          <th>
            @include('layouts.orders.cancel_order_request_status', ['request' => $cancelOrderRequest])
          </th>
        </tr>
      </table>
    </div>
  </div>
