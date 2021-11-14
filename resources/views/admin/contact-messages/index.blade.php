@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Contact Messages Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Contact Messages List
        </h6>

          <div class="table-wrapper">
            <table id="datatableAjax" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Message ID</th>
                  <th class="wd-15p">Sender</th>
                  <th class="wd-15p">Subject</th>
                  <th class="wd-15p">Date</th>
                  @canany(['view contact messages', 'reply contact messages', 'delete contact messages'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    @push('datatableAjax')
      columns: [
        { data: "id"},
        { data: "name"},
        { data: "subject"},
        { data: "created_at"},
        { data: 'action', orderable: false, searchable: false}
      ],
    @endpush  
@endsection