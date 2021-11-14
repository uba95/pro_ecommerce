@extends('layouts.admin.index')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Products Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Products List
            @can('create products')
              <a href ='{{ route('admin.products.create') }}' class="btn btn-sm btn-success float-right">Add New Product</a>
            @endcan
        </h6>

          <div class="table-wrapper">
            <table id="datatableAjax" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">SKU</th>
                  <th class="wd-15p">Cover</th>
                  <th class="wd-15p">Product Name</th>
                  <th class="wd-15p">Category</th>
                  <th class="wd-15p">Brand</th>
                  <th class="wd-15p">Quantity</th>
                  <th class="wd-15p">Status</th>
                  @canany(['view products', 'edit products', 'delete products'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    @push('datatableAjax')
      columns: [
        { data: "sku"},
        { data: "cover", orderable: false, searchable: false},
        { data: "product_name"},
        { data: "category.category_name"},
        { data: "brand.brand_name", "defaultContent": ""} ,
        { data: "product_quantity"},
        { data: "status"},
        { data: 'action', orderable: false, searchable: false}
      ],
    @endpush
@endsection
