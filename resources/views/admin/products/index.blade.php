@extends('admin.admin_layouts')


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
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Product Code</th>
                  <th class="wd-15p">Product Name</th>
                  <th class="wd-15p">Quantity</th>
                  <th class="wd-15p">Category</th>
                  <th class="wd-15p">Brand</th>
                  <th class="wd-15p">Image</th>
                  <th class="wd-15p">Status</th>
                  @canany(['edit products', 'delete products'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_code }}</td>
                        <td><a href ='{{ route('admin.products.show', $product->id) }}'>{{ $product->product_name }}</a></td>
                        <td>{{ $product->product_quantity }}</td>
                        <td>{{ $product->category->category_name }}</td>
                        <td>{{ $product->brand->brand_name }}</td>
                        <td>
                            <img src="{{ $product->cover }}" alt="" width="100" height="40">
                        </td>
                        <td>
                            <span class="badge {{ $product->status == 1 ? 'badge-success' : 'badge-danger' }}">
                              {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        @canany(['edit products', 'delete products'])
                        <td class="d-flex">
                          @can('edit products')
                            <a href ='{{ route('admin.products.edit', $product->id) }}' ><i class=" btn btn-sm btn-info fa fa-edit fa-fw" title="edit"></i></a>
                            <a href ='{{ route('admin.products.status', $product->id) }}' ><i class=" btn btn-sm btn-warning fa fa-lightbulb-o fa-fw" title="change status"></i></a>
                          @endcan
                          @can('delete products')
                            <form method="POST" action='{{ route('admin.products.destroy', $product->id) }}' class="delete">
                              @csrf @method('DELETE')
                              <i class=" btn btn-sm btn-danger fa fa-trash fa-fw" title="delete" ></i>
                            </form>
                          @endcan
                        </td>
                        @endcanany
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
@endsection