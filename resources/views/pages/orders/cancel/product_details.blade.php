<div class="card col-lg-12 p-0">
    <h6 class="card-header">Cancel Order Item Details</h6>
    <div class="table-wrapper">
      <table class="table display responsive nowrap">
        <thead>
          <tr>
            <th class="wd-15p">Cancel Order Item #</th>
            <th class="wd-15p">Order Item #</th>
            <th class="wd-15p">Product Name</th>
            <th class="wd-15p">Quantity</th>
            <th class="wd-15p">Unit Price</th>
            <th class="wd-20p">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($cancelOrderItems as $cancelOrderItem)
          <tr>
            <td>{{ $cancelOrderItem->id }}</td>
            <td>{{ $cancelOrderItem->orderItem->id }}</td>
            <td>{{ $cancelOrderItem->orderItem->product_name }}</td>
            <td>{{ $cancelOrderItem->product_quantity }}</td>
            <td>{{ $cancelOrderItem->orderItem->product_price }}$</td>
            <td>{{ $cancelOrderItem->totalPrice }}$</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div><!-- table-wrapper -->
  </div><!-- card -->
