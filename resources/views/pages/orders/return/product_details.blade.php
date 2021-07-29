<div class="card col-lg-12 p-0">
    <h6 class="card-header">Return Order Item Details</h6>
    <div class="table-wrapper">
      <table class="table display responsive nowrap">
        <thead>
          <tr>
            <th class="wd-15p">Return Order Item #</th>
            <th class="wd-15p">Order Item #</th>
            <th class="wd-15p">Product Name</th>
            <th class="wd-15p">Quantity</th>
            <th class="wd-15p">Unit Price</th>
            <th class="wd-20p">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($returnOrderItems as $returnOrderItem)
          <tr>
            <td>{{ $returnOrderItem->id }}</td>
            <td>{{ $returnOrderItem->orderItem->id }}</td>
            <td>{{ $returnOrderItem->orderItem->product_name }}</td>
            <td>{{ $returnOrderItem->product_quantity }}</td>
            <td>{{ $returnOrderItem->orderItem->product_price }}$</td>
            <td>{{ $returnOrderItem->totalPrice }}$</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div><!-- table-wrapper -->
  </div><!-- card -->
