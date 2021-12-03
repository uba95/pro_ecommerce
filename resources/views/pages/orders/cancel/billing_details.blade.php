<div class="card">
    @if ($cancelOrderRequest->billingAddress)
      <h6 class="card-header">Billing Details</h6>
    @endif
    <div class="card-body">
      <table class="table">

        <tr>
          <th> Name: </th>
          <th> {{ $cancelOrderRequest->order->user->name }} </th>
        </tr>

        @if ($cancelOrderRequest->billing_address_id && $cancelOrderRequest->billing_address_id != $cancelOrderRequest->shipping_address_id)
            
          <tr>
            <th> Phone: </th>
            <th> {{ $cancelOrderRequest->billingAddress->phone }} </th>
          </tr>

          <tr>
            <th> Address1: </th>
            <th> {{ $cancelOrderRequest->billingAddress->address_1 }} </th>
          </tr>
          <tr>
            <th> Address2: </th>
            <th> {{ $cancelOrderRequest->billingAddress->address_2 }} </th>
          </tr>

          <tr>
            <th> City : </th>
            <th> {{ $cancelOrderRequest->billingAddress->city }} </th>
          </tr>

          <tr>
            <th> Country : </th>
            <th> {{ $cancelOrderRequest->billingAddress->country->name }} </th>
          </tr>
        @endif


        <tr>
          <th> Canceled Items Total Price </th>
          <th> {{ $cancelOrderRequest->cancelOrderItems->sum->totalPrice }} $ </th>
        </tr>
        <tr>
          <th> Shipping Cost : </th>
          <th> {{ $cancelOrderRequest->shipping_cost ?? 0 }} $ </th>
        </tr>

        <tr>
          <th> Date: </th>
          <th> 
              {{ $cancelOrderRequest->created_at->isoFormat('Y-MM-DD HH:mm') }} 
              <div class="ml-2 text-muted small text-left">{{ $cancelOrderRequest->created_at->diffForHumans() }} </div>
          </th>
        </tr>
      </table>
      @if ($cancelOrderRequest->billing_address_id == $cancelOrderRequest->shipping_address_id)
        <strong class="alert alert-secondary" style="display: inline-block">Billing Address Is Same As Shipping Address</strong>
      @endif
    </div>
  </div>
