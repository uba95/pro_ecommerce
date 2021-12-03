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
                    <th class="wd-20p" data-orderable="false" data-searchable="false">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->advert_headline }}</td>
                        <td>{{ $item->advert_text }}</td>
                        
                        @include('admin.landing_page_items.status_action')
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