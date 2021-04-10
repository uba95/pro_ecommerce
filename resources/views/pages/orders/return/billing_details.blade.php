<div class="card">
    <h6 class="card-header">Billing Details</h6>
    <div class="card-body">
      <table class="table">

        <tr>
          <th> Name: </th>
          <th> {{ $returnOrderRequest->order->user->name }} </th>
        </tr>

        @if ($returnOrderRequest->billing_address_id != $returnOrderRequest->shipping_address_id)
            
          <tr>
            <th> Phone: </th>
            <th> {{ $returnOrderRequest->billingAddress->phone }} </th>
          </tr>

          <tr>
            <th> Address1: </th>
            <th> {{ $returnOrderRequest->billingAddress->address_1 }} </th>
          </tr>
          <tr>
            <th> Address2: </th>
            <th> {{ $returnOrderRequest->billingAddress->address_2 }} </th>
          </tr>

          <tr>
            <th> City : </th>
            <th> {{ $returnOrderRequest->billingAddress->city }} </th>
          </tr>

          <tr>
            <th> Country : </th>
            <th> {{ $returnOrderRequest->billingAddress->country->name }} </th>
          </tr>
        @endif

        <tr>
          <th> Payment Method: </th>
          <th>{{ $returnOrderRequest->payment_method }} </th>
        </tr>

        <tr>
          <th> Shipping Cost : </th>
          <th> {{ $returnOrderRequest->shipping_cost }} $ </th>
        </tr>

        <tr>
          <th> Date: </th>
          <th> 
              {{ $returnOrderRequest->created_at->isoFormat('Y-MM-DD HH:mm') }} 
              <div class="ml-2 text-muted small text-left">{{ $returnOrderRequest->created_at->diffForHumans() }} </div>
          </th>
        </tr>
      </table>
      @if ($returnOrderRequest->billing_address_id == $returnOrderRequest->shipping_address_id)
        <strong class="alert alert-secondary">Billing Address Is Same As Shipping Address</strong>
      @endif
    </div>
  </div>
