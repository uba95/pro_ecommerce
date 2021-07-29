<div class="card">
    <h6 class="card-header">Shipping Details</h6>
    <div class="card-body">
      <table class="table">

        <tr>
          <th> Phone: </th>
          <th> {{  $returnOrderRequest->shippingAddress->phone }} </th>
        </tr>

        <tr>
          <th> Address1: </th>
          <th> {{  $returnOrderRequest->shippingAddress->address_1 }} </th>
        </tr>

        <tr>
          <th> Address2: </th>
          <th> {{  $returnOrderRequest->shippingAddress->address_2 }} </th>
        </tr>

        <tr>
          <th> City : </th>
          <th> {{  $returnOrderRequest->shippingAddress->city }} </th>
        </tr>

        <tr>
          <th> Country : </th>
          <th> {{  $returnOrderRequest->shippingAddress->country->name }} </th>
        </tr>

        <tr>
          <th> Status: </th>
          <th>
            @include('layouts.orders.return_order_request_status', ['request' => $returnOrderRequest])
          </th>
        </tr>

        @if ($returnOrderRequest->shipping_started_at)
          <tr>
            <th> Started At: </th>
            <th>
              {{ $returnOrderRequest->shipping_started_at->isoFormat('Y-MM-DD HH:mm') }}
              <div class="ml-2 text-muted small text-left">
                {{ $returnOrderRequest->shipping_started_at->diffForHumans() }}
              </div>
            </th>
          </tr>
        @endif

      @if ($returnOrderRequest->shipping_returned_at)
        <tr>
          <th> Returned At: </th>
          <th>
            {{ $returnOrderRequest->shipping_returned_at->isoFormat('Y-MM-DD HH:mm') }}
            <div class="ml-2 text-muted small text-left">
              {{ $returnOrderRequest->shipping_returned_at->diffForHumans() }}
            </div>
          </th>
        </tr>
      @endif

      </table>
    </div>
  </div>
