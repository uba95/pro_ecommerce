<div class="card">
    <h6 class="card-header">Shipping Details</h6>
    <div class="card-body">
      <table class="table">

        <tr>
          <th> Phone: </th>
          <th> {{ $order->shipment->address->phone }} </th>
        </tr>

        <tr>
          <th> Address1: </th>
          <th> {{ $order->shipment->address->address_1 }} </th>
        </tr>

        <tr>
          <th> Address2: </th>
          <th> {{ $order->shipment->address->address_2 }} </th>
        </tr>

        <tr>
          <th> City : </th>
          <th> {{ $order->shipment->address->city }} </th>
        </tr>

        <tr>
          <th> Country : </th>
          <th> {{ $order->shipment->address->country->name }} </th>
        </tr>

        <tr>
          <th> Status: </th>
          <th>
            @include('layouts.orders.order_status')
          </th>
        </tr>

        @if ($order->shipment->started_at)
          <tr>
            <th> Started At: </th>
            <th>
              {{ $order->shipment->started_at->isoFormat('Y-MM-DD HH:mm') }}
              <div class="ml-2 text-muted small text-left">{{ $order->shipment->started_at->diffForHumans() }} </div>
            </th>
          </tr>
        @endif

        @if ($order->shipment->delivered_at)
          <tr>
            <th> Delivered At: </th>
            <th>
              {{ $order->shipment->delivered_at->isoFormat('Y-MM-DD HH:mm') }}
              <div class="ml-2 text-muted small text-left">{{ $order->shipment->delivered_at->diffForHumans() }} </div>
            </th>
          </tr>
        @endif

      </table>
    </div>
  </div>