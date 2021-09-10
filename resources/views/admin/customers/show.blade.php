@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Customers Details </h6>
                <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="card">
                                <h6 class="card-header">Customers Details</h6>
                                <div class="card-body">
                                  <table class="table"> 
                                    
                                    <tr>
                                      <th> Name: </th>
                                      <th> {{ $customer->name }} </th>
                                    </tr>
                            
                                    <tr>
                                      <th> Email: </th>
                                      <th>{{ $customer->email }} </th>
                                    </tr>
                            
                                    <tr>
                                      <th> Phone Number: </th>
                                      <th> {{ $customer->phone }}</th>
                                    </tr>
                            
                                    <tr>
                                      <th> Date: </th>
                                      <th> 
                                          {{ $customer->created_at->isoFormat('Y-MM-DD HH:mm') }} 
                                          <div class="ml-2 text-muted small text-left">{{ $customer->created_at->diffForHumans() }} </div>
                                      </th>
                                    </tr>
                
                                  </table>
                                </div>
                            </div>                
                        </div>

                        <div class="col-md-4 text-center">
                            <img src="{{ $customer->avatar }}" alt="" style="max-width: 200px;max-height:200px">
                        </div>
                </div>

                @if ($customer->addresses->isNotEmpty())
                  <div class="row">
                    <div class="card col-lg-12 p-0">
                      <h6 class="card-header">Addresses</h6>
                      <div class="table-wrapper">
                        <table class="table display responsive nowrap">
                          <thead>
                            <tr>
                              <th class="wd-15p">alias</th>
                              <th class="wd-15p">address_1</th>
                              <th class="wd-15p">address_2</th>
                              <th class="wd-15p">zip</th>
                              <th class="wd-15p">city</th>
                              <th class="wd-15p">country</th>
                              <th class="wd-15p">phone</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($customer->addresses as $address)
                            <tr>
                              <td>{{ $address->alias }}</td>
                              <td>{{ $address->address_1 }}</td>
                              <td>{{ $address->address_2 }}</td>
                              <td>{{ $address->zip }}</td>
                              <td>{{ $address->city }}</td>
                              <td>{{ $address->country->name }}</td>
                              <td>{{ $address->phone }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div><!-- table-wrapper -->
                    </div><!-- card -->
                  </div>
                @endif

                <div class="row my-3">
                  <div class="card p-0">
                      <h6 class="card-header py-1">Customer Orders</h6>
                      <div class="card-body py-1">
                        <table class="table"> 
                            @if ($customer->orders->isNotEmpty())      
                              @foreach ($customer->orders as $key => $order)
                                <tr>
                                  <th><a href ='{{ route('admin.orders.show', $order->id) }}'>Order {{ $key + 1 }}</a></th>
                                  <th>@include('layouts.orders.order_status')  </th>
                                </tr>
                              @endforeach
                           @endif
                        </table>
                      </div>
                  </div>                
              </div>

          </div>
      </div>
  </div>
@endsection
