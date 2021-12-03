@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Roles Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            Roles List
            @can('create roles')
              <a href ='{{ route('admin.roles.create') }}' class="btn btn-sm btn-success float-right">Add New Role</a>
            @endcan
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Role ID</th>
                  <th class="wd-15p">Role Name</th>
                  <th class="wd-15p">Role Permissions</th>
                  @canany(['edit roles', 'delete roles'])
                    <th class="wd-20p" data-orderable="false" data-searchable="false">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td><a href ='{{ route('admin.roles.show', $role->id) }}'>{{ ucwords($role->name) }}</a></td>
                        <td>
                            @if ($role->getPermissionNames()->isNotEmpty())
                            @foreach ($role->getPermissionNames() as $permission)
                                <span class="badge badge-dark">{{ $permission }}</span>                                
                            @endforeach
                            @else
                                No Permissions
                            @endif
                        </td>
                        @canany(['edit roles', 'delete roles'])
                          <td>
                            @can('edit roles')
                            <a href ='{{ route('admin.roles.edit', $role->id) }}' class="btn btn-sm btn-info">Edit</a>
                            @endcan
                            @can('delete roles')
                            <form method="POST" action='{{ route('admin.roles.destroy', $role->id) }}' class="btn btn-sm btn-danger delete">
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