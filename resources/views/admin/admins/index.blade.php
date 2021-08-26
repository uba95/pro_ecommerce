@extends('admin.admin_layouts')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Admins Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Admins List
            @can('create admins')
              <a href ='{{ route('admin.admins.create') }}' class="btn btn-sm btn-success float-right">Add New Admin</a>
            @endcan
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Admin ID</th>
                  <th class="wd-15p">Admin Name</th>
                  <th class="wd-15p">Admin Roles</th>
                  @canany(['edit admins', 'delete admins'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($admins as $key => $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td><a href ='{{ route('admin.admins.show', $admin->id) }}'>{{ ucwords($admin->name) }}</a></td>
                        <td>
                            @if ($admin->getRoleNames()->isNotEmpty())
                            @foreach ($admin->getRoleNames() as $role)
                                <span class="badge badge-dark">{{ $role }}</span>                                
                            @endforeach
                            @else
                                No Roles
                            @endif
                        </td>
                        @canany(['edit admins', 'delete admins'])
                          <td>
                              @can('edit', $admin)
                                <a href ='{{ route('admin.admins.edit', $admin->id) }}' class="btn btn-sm btn-info">Edit</a>
                              @endcan
                              @can('delete', $admin)
                                <form method="POST" action='{{ route('admin.admins.destroy', $admin->id) }}' class="btn btn-sm btn-danger delete">
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