@extends('layouts.admin.index')

@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Sales By</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Date Range</h6>
          <div class="col-12 col-sm-4 my-4">
            <form action ='{{ route('admin.reports.salesBy') }}' method="POST"> @csrf
              <div class="my-3 d-flex align-items-center justify-content-between">
                <label class="mx-2 mb-0 w-25">From</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input name="from" type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ $from ?? '' }}">
                </div>
              </div>
              <div class="my-3 d-flex align-items-center justify-content-between">
                <label class="mx-2 mb-0  w-25">To</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input name="to" type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ $to ?? '' }}">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block my-3">Submit</button>
            </form>  
          </div>
          @if (isset($products))
              
          <h6 class="card-body-title">Sales By Product</h6>
            <div class="table-wrapper">
              <table id="datatable1" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th class="wd-15p">Product Name</th>
                    <th class="wd-15p">Sold Quantity</th>
                    <th class="wd-15p">Returned Quantity</th>
                    <th class="wd-15p">Net Quantity</th>
                    <th class="wd-15p">Sales</th>
                    <th class="wd-15p">Returns</th>
                    <th class="wd-15p">Net Sales</th>
                  </tr>
                </thead>
                <tbody>
      
                  @foreach($products as $key => $item)
                  <tr>
                    <td><a href ='{{ route('admin.products.show', $item->product_id) }}'>{{ $item->product_name }}</a></td>
                    <td>{{ $item->sold_quantity }}</td>
                    <td>{{ $item->returns_quantity }}</td>
                    <td>{{ $item->net_quantity }}</td>
                    <td>{{ $item->sales }}$</td>
                    <td>{{ $item->returns }}$</td>
                    <td>{{ $item->net_sales }}$</td>
                  </tr>
                  @endforeach
  
                </tbody>
              </table>
            </div><!-- table-wrapper -->  
        </div><!-- card -->

        @endif
    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->
@endsection