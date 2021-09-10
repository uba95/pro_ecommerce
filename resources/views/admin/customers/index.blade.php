@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Customers Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Customers List
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">ID</th>
                  <th class="wd-15p">Name</th>
                  <th class="wd-15p">Email</th>
                  <th class="wd-15p">Phone</th>
                  @can('delete customers')
                    <th class="wd-20p">Action</th>
                  @endcan
                </tr>
              </thead>
              <tbody>
                @foreach ($customers as $key => $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td><a href ='{{ route('admin.customers.show', $customer->id) }}'>{{ ucwords($customer->name) }}</a></td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        @can('delete customers')
                            <td>
                                <form method="POST" action='{{ route('admin.customers.destroy', $customer->id) }}' class="btn btn-sm btn-danger delete">
                                @csrf @method('DELETE') Delete
                                </form>
                            </td>
                        @endcan
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