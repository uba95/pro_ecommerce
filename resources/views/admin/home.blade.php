@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Ecommmerce</a>
        <span class="breadcrumb-item active">Dashboard</span>
      </nav>

      <div class="sl-pagebody">

        @can('view orders')
          
        <div class="row row-sm mg-t-20">
          <div class="col-lg-12">
            <div class="card overflow-hidden mb-4">
              <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                <div class="mg-b-20 mg-sm-b-0">
                  <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Last 30 Days</h6>
                  {{-- <span class="d-block tx-12">October 23, 2017</span> --}}
                </div>
              </div><!-- card-header -->
              <div class="card-body pd-0 bd-color-gray-lighter">
                <div class="row no-gutters tx-center">
                  {{-- <div class="col-12 col-sm-4 pd-y-20 tx-left">
                    <p class="pd-l-20 tx-12 lh-8 mg-b-0">Note: Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula...</p>
                  </div><!-- col-4 --> --}}
                  @foreach ($last30Days as $key => $item)

                  <div class="col-6 col-sm-2 pd-y-20">
                    <h4 class="tx-inverse tx-lato tx-bold mg-b-5">{{ $item }}</h4>
                    <p class="tx-11 mg-b-0 tx-uppercase">{{ $key }}</p>
                  </div><!-- col-2 -->

                  @endforeach

                </div><!-- row -->
              </div><!-- card-body -->
              <div class="card-body pd-0">
                <canvas id="chartArea1" height="100"></canvas>
              </div><!-- card-body -->
            </div><!-- card -->
          </div>

          <div class="col-lg-6 mg-t-20 mg-lg-t-0">
            <div class="card mb-4 bd-0">
              <div class="card-header  card-header-default bg-light card-title tx-uppercase tx-12 mg-b-0 bd-b bd-gray-200">
                Price Totals
              </div><!-- card-header -->
              <div class="card-body bd bd-t-0 rounded-bottom">

                @foreach ($priceTotals as $key => $price)
                <div class="d-flex justify-content-between tx-inverse  tx-12">
                  <strong class="tx-uppercase">{{ $key }}</strong>
                  <span>${{ $price }}</span>
                </div>
                <hr>
                @endforeach

              </div><!-- card-body -->
            </div><!-- card -->
          </div>

          <div class="card mb-4 pd-20 pd-sm-25 col-lg-6">
            <h6 class="card-body-title">Payment Methods Totals</h6>
            <p class="mg-b-20 mg-sm-b-30"></p>
            <div id="flotPie2" class="ht-200 ht-sm-250"></div>
          </div><!-- card -->

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

          <div class="col-lg-6 mg-t-20 mg-lg-t-0">
            <div class="card mb-4">
              <div class="card-header pd-20 bg-transparent bd-b bd-gray-200">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Most Sold Products Last 30 Days</h6>
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
                  @foreach ($mostSoldProductsLast30Days as $orderItem)
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
        
        @endcan

      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    @can('view orders')
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


        <script>

          $(function() {

            var days = @json($salesLast30Days->collapse()->keys());
            var sales = @json($salesLast30Days->collapse()->values());
            var ctx5 = document.getElementById('chartArea1');

            var myChart5 = new Chart(ctx5, {
              type: 'line',
              data: {
                labels: [...days],
                datasets: [{
                  data: [...sales],
                  backgroundColor: '#7CBDDF', //rgba(240, 113, 36, 0.4)
                  fill: true,
                  borderWidth: 0,
                  borderColor: '#fff'
                }]
              },
              options: {
                legend: {
                  display: false,
                    labels: {
                      display: false
                    }
                },
                layout: {
                  padding: {
                      left: 10
                  }
                },
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero:true,
                      fontSize: 11,
                      max: Math.ceil(Math.max(...sales)/1000)*1000,  
                      stepSize: 1000, 
                      callback: function(value) {
                        var ranges = [
                            { divider: 1e6, suffix: 'M' },
                            { divider: 1e3, suffix: 'k' }
                        ];
                        function formatNumber(n) {
                            for (var i = 0; i < ranges.length; i++) {
                              if (n >= ranges[i].divider) {
                                  return (n / ranges[i].divider).toString() + ranges[i].suffix;
                              }
                            }
                            return n;
                        }
                        return '$' + formatNumber(value);
                      }
                    }
                  }],
                  xAxes: [{
                    ticks: {
                      beginAtZero:true,
                      fontSize: 10
                    }
                  }]
                }
              }
            });

          });

        </script>
      @endpush
    @endcan
@endsection
