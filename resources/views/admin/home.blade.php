@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Ecommmerce</a>
        <span class="breadcrumb-item active">Dashboard</span>
      </nav>

      <div class="sl-pagebody">

        @can('view orders')
          
        <br><br><br>
        <div class="row row-sm mg-t-20">
          <div class="col-lg-6">
            <div class="card p-1">
              <div class="card-header bg-transparent pd-20 bd-b bd-gray-200">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Latest Orders</h6>
              </div><!-- card-header -->
              <table class="table table-white  mg-b-0 tx-12">
                <thead>
                  <tr class="tx-10">
                    <th class="pd-y-5">Order #</th>
                    <th class="pd-y-5">Price</th>
                    <th class="pd-y-5">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($latest_orders as $order)
                  <tr>
                    <td>
                      <a href ='{{ route('admin.orders.show', $order->id) }}' class="tx-inverse tx-14 tx-medium d-block">{{ $order->id }}</a>
                      <span class="tx-11 d-block">{{ $order->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                      <div class="tx-inverse tx-14 tx-medium d-block">${{ $order->total_price }}</div>
                    </td>
                    <td>
                      <div class="tx-inverse tx-medium d-block">
                        @include('layouts.orders.order_status')
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-gray-200">
                <a href ='{{ route('admin.orders.index') }}'><i class="fa fa-angle-down mg-r-5"></i>View All Orders</a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->



          <div class="col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card">
              <div class="card-header pd-20 bg-transparent bd-b bd-gray-200">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Latest Product Purchases</h6>
              </div><!-- card-header -->
              <table class="table table-white table-responsive mg-b-0 tx-12">
                <thead>
                  <tr class="tx-10">
                    <th class="wd-10p pd-y-5">&nbsp;</th>
                    <th class="pd-y-5">Item Details</th>
                    <th class="pd-y-5 tx-right">Sold</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mostSoldProductsThisMonth as $orderItem)
                  <tr>
                    <td class="pd-l-20">
                      <img src="{{ $orderItem->product->cover  }}" class="wd-55" alt="Image">
                    </td>
                    <td>
                      <a href ='{{ route('admin.products.show', $orderItem->product_id) }}' class="tx-inverse tx-14 tx-medium d-block">
                        {{ $orderItem->product_name }}
                      </a>
                      <span class="tx-11 d-block">
                        <span class="square-8 mg-r-5 rounded-circle 
                        {{ $orderItem->product->stockStatus ==  "in" 
                        ? "bg-success" 
                        : ($orderItem->product->stockStatus == "out" ? "bg-danger" : "bg-warning")}}">
                        </span> 
                        {{ $orderItem->product->product_quantity }} remaining
                      </span>
                    </td>
                    <td class="valign-middle tx-right"> {{ $orderItem->sold_quantity }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="card-footer tx-12 pd-y-15 bg-transparent bd-t bd-b-200">
                <a href ='{{ route('admin.stocks.index') }}'><i class="fa fa-angle-down mg-r-5"></i>View All Stocks</a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->
        </div><!-- row -->
       <br> <br> <br>
        <div class="row">
          @foreach ($lists as $key => $list)
          <div class="col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card bd-0">
              <div class="card-header  card-header-default bg-light card-title tx-uppercase tx-12 mg-b-0 bd-b bd-gray-200">
                {{ $listsNames[$key] }}
              </div><!-- card-header -->
              <div class="card-body bd bd-t-0 rounded-bottom">
                @foreach ($list as $key => $item)
                <div class="d-flex justify-content-between tx-inverse  tx-12">
                  <strong class="tx-uppercase">{{ $key }}</strong>
                  <span>{{ $item }}</span>
                </div>
                <hr>
                @endforeach
              </div><!-- card-body -->
            </div><!-- card -->
          </div>
          @endforeach

          <div class="card pd-20 pd-sm-25 col-lg-4">
            <h6 class="card-body-title">Payment Methods Totals</h6>
            <p class="mg-b-20 mg-sm-b-30"></p>
            <div id="flotPie2" class="ht-200 ht-sm-250"></div>
          </div><!-- card -->
        </div><!-- row -->
        
        @endcan

      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    @push('charts')
      <script>
        var paymentMethods = @json($paymentMethods);
        var piedata = [];
        paymentMethods.forEach( (v) => piedata.push({ label: v.label, data: [[1, v.data]], color: v.color}) )

        $.plot('#flotPie2', piedata, {
          series: {
            pie: {
              show: true,
              radius: 1,
              innerRadius: 0.5,
              label: {
                show: true,
                radius: 2/3,
                formatter: labelFormatter,
                threshold: 0.1
              }
            }
          },
          grid: {
            hoverable: true,
            clickable: true
          },
          legend: { show: true }
        });

        function labelFormatter(label, series) {
          return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + Math.round(series.percent) + "%</div>";
        }
      </script>
    @endpush
@endsection
