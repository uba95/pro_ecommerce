@extends('admin.admin_layouts')

@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Sales By</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Sales By Form</h6>
          <div class="col-12 col-sm-4 my-4">
            <form action ='{{ route('admin.reports.salesBy') }}' method="POST"> @csrf
              <select name="by" class="form-control select2 my-3" data-placeholder="Sales By">
                <option value=""></option>
                <option value="order">Order</option>
                <option value="product">Product</option>
                <option value="country">Billing Country</option>
                <option value="customer">Customer</option>
              </select>
              <div class="my-3 d-flex align-items-center justify-content-between">
                <label class="mx-2 mb-0 w-25">From</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input name="from" type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                </div>
              </div>
              <div class="my-3 d-flex align-items-center justify-content-between">
                <label class="mx-2 mb-0  w-25">To</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input name="to" type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block my-3">Submit</button>
            </form>  
          </div>
          @if (isset($sales))
              
          <h6 class="card-body-title">Sales By {{ ucwords($salesBy) }}</h6>
        @switch($salesBy)
            @case('product')
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
      
                  @foreach($sales as $key => $item)
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
                @break
            @case(2)
                
                @break
            @default
                
        @endswitch
        </div><!-- card -->

        @endif
    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->
@endsection