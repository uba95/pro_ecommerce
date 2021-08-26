@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Permissions Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Permissions List
            @can('create permissions')
              <a href="" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modaldemo3">Add New Permission</a>
            @endcan
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Permission ID</th>
                  <th class="wd-15p">Permission Name</th>
                  @canany(['edit permissions', 'delete permissions'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($permissions as $key => $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ ucwords($permission->name) }}</td>
                        @canany(['edit permissions', 'delete permissions'])
                          <td>
                            @can('edit permissions')
                              <a href ='{{ route('admin.permissions.edit', $permission->id) }}' class="btn btn-sm btn-info">Edit</a>
                            @endcan
                            @can('delete permissions')
                              <form method="POST" action='{{ route('admin.permissions.destroy', $permission->id) }}' class="btn btn-sm btn-danger delete">
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
    @can('create permissions')
      <!-- LARGE MODAL -->
      <div id="modaldemo3" class="modal fade">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content tx-size-sm">
                  <div class="modal-header pd-x-20">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Permission</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>

                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif

                  <form action ='{{ route('admin.permissions.store') }}' method="POST">
                      @csrf
                      <div class="modal-body pd-20">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Permission Name</label>
                            <input type="text" class="form-control" name="name">
                          </div>
                      </div><!-- modal-body -->
                      <div class="modal-footer">
                              <button type="submit" class="btn btn-info pd-x-20">Add</button>
                              <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                      </div>
                      
                  </form>
              </div>
          </div><!-- modal-dialog -->
      </div><!-- modal -->
    @endcan
@endsection