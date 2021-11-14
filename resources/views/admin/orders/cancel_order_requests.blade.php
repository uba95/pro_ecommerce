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
                  <th class="wd-15p">Requset ID</th>
                  <th class="wd-15p">Order ID</th>
                  <th class="wd-15p">Customer</th>
                  <th class="wd-20p">Requset Date</th>
                  <th class="wd-20p">Order Date</th>
                  <th class="wd-20p">Requset Status</th>
                  <th class="wd-20p">Order Status</th>
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
      { data: "request_show" },
      { data: "order_show" },
      { data: "order.user.name" },
      { data: "created_at" },
      { data: "order.created_at" },
      { data: "request_status" },
      { data: "order_status" },
      { data: "action", orderable: false, searchable: false },
    ],
  @endpush
@endsection