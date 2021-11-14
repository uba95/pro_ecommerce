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
            <form action ='{{ route('admin.reports.salesBy.products') }}' method="GET">
              <div class="my-3 d-flex align-items-center justify-content-between">
                <label class="mx-2 mb-0 w-25">From</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input name="from" type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ request('from') }}">
                </div>
              </div>
              <div class="my-3 d-flex align-items-center justify-content-between">
                <label class="mx-2 mb-0  w-25">To</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input name="to" type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" value="{{ request('to') }}">
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block my-3">Submit</button>
            </form>  
          </div>
          {{-- {{ dd(request('from')) }} --}}
          @if (request('from'))
              
          <h6 class="card-body-title">Sales By Product</h6>
            <div class="table-wrapper">
              <table id="datatableAjax" class="table display responsive nowrap">
                <thead>
                  <tr>
                    <th class="wd-15p">Product Name</th>
                    <th class="wd-15p">Sold Quantity</th>
                    <th class="wd-15p">Returned Quantity</th>
                    <th class="wd-15p">Net Quantity</th>
                    <th class="wd-15p">Sales</th>
                    <th class="wd-15p">Returns</th>
                    <th class="wd-15p">Net Sales</th>
                    <th class="wd-15p">Action</th>
                  </tr>
                </thead>
              </table>
            </div><!-- table-wrapper -->  
        </div><!-- card -->
        @push('datatableAjax')
          "ajax": {
              "url": `{{ request()->url() }}`,
              "type": 'GET',
              "data":  function () {return $('form').serialize()}
          },
          columns: [
            { data: "product_name" },
            { data: "sold_quantity" },
            { data: "returns_quantity" },
            { data: "net_quantity" },
            { data: "sales" },
            { data: "returns" },
            { data: "net_sales" },
            { data: 'action', orderable: false, searchable: false}
            ],
        @endpush
        @endif
    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->
@endsection