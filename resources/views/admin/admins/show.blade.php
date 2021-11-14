@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Admin Details </h6>
                <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <h6 class="card-header">Admin Details</h6>
                                <div class="card-body">
                                  <table class="table"> 
                                    
                                    <tr>
                                      <th> Name: </th>
                                      <th> {{ $admin->name }} </th>
                                    </tr>
                            
                                    <tr>
                                      <th> Email: </th>
                                      <th>{{ $admin->email }} </th>
                                    </tr>
                            
                                    <tr>
                                      <th> Phone Number: </th>
                                      <th> {{ $admin->phone }}</th>
                                    </tr>
                            
                                    <tr>
                                      <th> Date: </th>
                                      <th> 
                                          {{ $admin->created_at->isoFormat('Y-MM-DD HH:mm') }} 
                                          <div class="ml-2 text-muted small text-left">{{ $admin->created_at->diffForHumans() }} </div>
                                      </th>
                                    </tr>
                
                                  </table>
                                </div>
                            </div>                
                        </div>

                        <div class="col-md-4">
                            <img src="{{ $admin->avatar }}" alt="" style="max-width: 100%">
                        </div>
                </div>

                <div class="row">
                    <div class="card">
                        <h6 class="card-header">Admin Roles</h6>
                        <div class="card-body">
                          <table class="table"> 

                            @if ($admin->getRoleNames()->isNotEmpty())
                                @foreach ($admin->getRoleNames() as $role)
                                    <tr>
                                        <th class="text-center">{{ ucwords($role) }}</th>
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
