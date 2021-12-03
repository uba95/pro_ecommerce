@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Site Settings </h6>
                <div class="row justify-content-between">
                        <div class="col-md-8">
                            <div class="card">
                                <h6 class="card-header">Site Settings</h6>
                                <div class="card-body">
                                  <table class="table"> 
                                    <tr>
                                        <th> Phone Number: </th>
                                        <th> {{ $settings->phone }} </th>
                                    </tr>
                                    <tr>
                                        <th> Email: </th>
                                        <th>{{ $settings->email }} </th>
                                    </tr>
                                    <tr>
                                        <th> Address: </th>
                                        <th> {{ $settings->address }}</th>
                                    </tr>
                                    <tr>
                                        <th> Facebook Page: </th>
                                        <th> {{ $settings->facebook }}</th>
                                    </tr>
                                    <tr>
                                        <th> Youtube Channel: </th>
                                        <th> {{ $settings->youtube }}</th>
                                    </tr>
                                    <tr>
                                        <th> Twitter Account: </th>
                                        <th> {{ $settings->twitter }}</th>
                                    </tr>
                                    <tr>
                                        <th> Instagram Account: </th>
                                        <th> {{ $settings->instagram }}</th>
                                    </tr>
                                  </table>
                                </div>
                            </div>                
                        </div>
                        <div class="col-md-2">
                            <a href ='{{ route('admin.site_settings.edit') }}' class="btn btn-sm btn-success">Edit Settings</a>
                        </div>
                </div>

                <div class="row justify-content-between">
                        <div class="col-md-8">
                            <div class="card">
                                <h6 class="card-header">Warehouse Settings</h6>
                                <div class="card-body">
                                    <table class="table"> 
                                        <tr>
                                            <th> Phone Number: </th>
                                            <th> {{ $settings->warehouse->phone }} </th>
                                        </tr>
                                        <tr>
                                            <th> Email: </th>
                                            <th>{{ $settings->warehouse->email }} </th>
                                        </tr>
                                        <tr>
                                            <th> Address 1: </th>
                                            <th> {{ $settings->warehouse->address_1 }}</th>
                                        </tr>
                                        <tr>
                                            <th> Address 2: </th>
                                            <th> {{ $settings->warehouse->address_2 }}</th>
                                        </tr>
                                        <tr>
                                            <th> Zip: </th>
                                            <th> {{ $settings->warehouse->zip }}</th>
                                        </tr>
                                        <tr>
                                            <th> City: </th>
                                            <th> {{ $settings->warehouse->city }}</th>
                                        </tr>
                                        <tr>
                                            <th> State: </th>
                                            <th> {{ $settings->warehouse->state }}</th>
                                        </tr>
                                        <tr>
                                            <th> Country: </th>
                                            <th> {{ $settings->warehouse->country }}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>                
                        </div>
                </div>
          </div>
      </div>
  </div>
@endsection
