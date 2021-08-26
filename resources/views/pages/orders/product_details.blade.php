<div class="card col-lg-12 p-0">
    <h6 class="card-header">Product Details</h6>
    <div class="table-wrapper">
      <table class="table display responsive nowrap">
        <thead>
          <tr>
            <th class="wd-15p">Order Item ID</th>
            <th class="wd-15p">Product ID</th>
            <th class="wd-15p">Product Name</th>
            <th class="wd-15p">Image</th>
            <th class="wd-15p">Color</th>
            <th class="wd-15p">Size</th>
            <th class="wd-15p">Quantity</th>
            <th class="wd-15p">Weight</th>
            <th class="wd-15p">Unit Price</th>
            <th class="wd-20p">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orderItems as $orderItem)
          <tr>
            <td>{{ $orderItem->id }}</td>
            <td>{{ $orderItem->product_id }}</td>
            <td>{{ $orderItem->product_name }}</td>
            <td> <img src="{{ $orderItem->product->cover }}" height="50px;" width="50px;"> </td>
            <td>{{ $orderItem->product_color }}</td>
            <td>{{ $orderItem->product_size }}</td>
            <td>{{ $orderItem->product_quantity }}</td>
            <td>{{ $orderItem->product_weight }}</td>
            <td>{{ $orderItem->product_price }}$</td>
            <td>{{ $orderItem->totalPrice }}$</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div><!-- table-wrapper -->
  </div><!-- card -->
