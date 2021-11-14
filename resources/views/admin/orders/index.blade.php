@extends('layouts.admin.index')

@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Order Details</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Order List</h6>
           
          <div class="table-wrapper">
            <table id="datatableAjax" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Order ID</th>
                  <th class="wd-15p">Customer</th>
                  <th class="wd-15p">Payment Method</th>
                  <th class="wd-15p">Total Price</th>
                  <th class="wd-20p">Date</th>
                  <th class="wd-20p">Status</th>
                  <th class="wd-20p">Action</th>
                </tr>
              </thead>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->

  @push('datatableAjax')
    "ajax": {
        "url": `{{ request()->url() }}`,
        "type": 'GET',
        "data":  {status: '{{request()->status}}'}
    },
    columns: [
      { data: "show" },
      { data: "user.name" },
      { data: "payment_method" },
      { data: "total_price" },
      { data: "created_at" },
      { data: "status" },
      { data: "action" },
    ],
  @endpush
@endsection