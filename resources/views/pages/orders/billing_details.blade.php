<div class="card">
    <h6 class="card-header">Billing Details</h6>
    <div class="card-body">
      <table class="table">

        <tr>
          <th> Name: </th>
          <th> {{ $order->user->name }} </th>
        </tr>

        @if ($order->address_id != $order->shipment->address_id)
            
          <tr>
            <th> Phone: </th>
            <th> {{ $order->address->phone }} </th>
          </tr>

          <tr>
            <th> Address1: </th>
            <th> {{ $order->address->address_1 }} </th>
          </tr>
          <tr>
            <th> Address2: </th>
            <th> {{ $order->address->address_2 }} </th>
          </tr>

          <tr>
            <th> City : </th>
            <th> {{ $order->address->city }} </th>
          </tr>

          <tr>
            <th> Country : </th>
            <th> {{ $order->address->country->name }} </th>
          </tr>
        @endif

        <tr>
          <th> Payment Method: </th>
          <th>{{ $order->payment_method }} </th>
        </tr>

        <tr>
          <th> Subtotal : </th>
          <th> {{ $order->subtotal_price }} $ </th>
        </tr>

        <tr>
          <th> Discount : </th>
          <th>- {{ $order->discount_price }} $ </th>
        </tr>

        <tr>
          <th> Shipping Cost : </th>
          <th> {{ $order->shipping_cost }} $ </th>
        </tr>

        <tr>
          <th> Total : </th>
          <th> {{ $order->total_price }} $ </th>
        </tr>

        <tr>
          <th> Date: </th>
          <th> 
              {{ $order->created_at->isoFormat('Y-MM-DD HH:mm') }} 
              <div class="ml-2 text-muted small text-left">{{ $order->created_at->diffForHumans() }} </div>
          </th>
        </tr>
      </table>
      @if ($order->address_id == $order->shipment->address_id)
      <strong class="alert alert-secondary" style="display: inline-block">Billing Address Is Same As Shipping Address</strong>
      @endif
    </div>
  </div>
