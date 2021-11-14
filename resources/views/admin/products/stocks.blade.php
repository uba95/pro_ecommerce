@extends('layouts.admin.index')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Stocks Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">

          <div class="table-wrapper">
            <table id="datatableAjax" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Product Id</th>
                  <th class="wd-15p">Product Name</th>
                  <th class="wd-15p">Quantity</th>
                  <th class="wd-15p">Action</th>
                </tr>
              </thead>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    @push('datatableAjax')
      "ajax": {
        "url": `{{ request()->url() }}`,
        "type": 'GET',
        "data":  {status: '{{request()->status}}'}
      },
      columns: [
        { data: "id" },
        { data: "product_name" },
        { data: "product_quantity" },
        { data: 'action', orderable: false, searchable: false}
      ],
    @endpush
@endsection