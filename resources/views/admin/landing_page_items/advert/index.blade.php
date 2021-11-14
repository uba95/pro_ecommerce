@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Adverts Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            @can('create landing page items')
              <a href ='{{ route('admin.landing_page_items.create', ['type' => 'advert']) }}' class="btn btn-sm btn-success float-right">
                Add New Advert
              </a>
            @endcan
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Item ID</th>
                  <th class="wd-15p">Headline</th>
                  <th class="wd-15p">Text</th>
                  <th class="wd-15p">Status</th>
                  @canany(['view landing page items', 'edit landing page items', 'delete landing page items'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->advert_headline }}</td>
                        <td>{{ $item->advert_text }}</td>
                        <td>
                          @if ($item->status == 'active')
                            <span class="badge badge-success">ACTIVE</span>
                          @else
                            <span class="badge badge-dark">INACTIVE</span>
                          @endif
                        </td>      
                        @canany(['view landing page items', 'edit landing page items', 'delete landing page items'])
                          <td>
                              @can('view', $item)
                              <a href ='{{ route('admin.landing_page_items.show', $item->id) }}' class="btn btn-sm btn-info">View</a>
                              @endcan
                              @can('edit', $item)
                                <a href ='{{ route('admin.landing_page_items.edit', $item->id) }}' class="btn btn-sm btn-info">Edit</a>
                                <a href ='{{ route('admin.landing_page_items.status', $item->id) }}' class="btn btn-sm btn-info"> Change Status</a>
                                @endcan
                              @can('delete', $item)
                                <form method="POST" action='{{ route('admin.landing_page_items.destroy', $item->id) }}' class="btn btn-sm btn-danger delete">
                                  @csrf @method('DELETE') Delete
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