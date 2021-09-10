@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">{{ ucwords($role->name) }} Role Details </h6>

                <div class="row">
                    <div class="card">
                        <h6 class="card-header">Role Permissions</h6>
                        <div class="card-body">
                          <table class="table table-striped"> 

                            @if ($role->getPermissionNames()->isNotEmpty())
                                @foreach ($role->getPermissionNames() as $permission)
                                    <tr>
                                        <th class="text-center">{{ ucwords($permission) }}</th>
                                    </tr>
                                @endforeach
                            @else
                                No Roles
                            @endif

                          </table>
                        </div>
                    </div>                
                </div>
          </div>
      </div>
  </div>
@endsection
