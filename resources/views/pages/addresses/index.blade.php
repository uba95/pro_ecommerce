@extends('layouts.app')
@section('content')

<div class="contact_form">
  <div class="container"> 
    <a href ='{{ route('addresses.create') }}' class="btn btn-success mb-3">Add New Address</a>

    <div class="row">
        
      <div class="col-8 card">

        <table class="table table-response">
          <thead>
            <tr>
              <th scope="col">Alias</th>
              <th scope="col">Address 1</th>
              <th scope="col">Address 2 </th>
              <th scope="col">City </th>
              <th scope="col">Country  </th>
              <th scope="col">Zip </th>
              <th scope="col">Phone </th>
              <th scope="col">Action </th>
            </tr>
          </thead>
          <tbody>
            @foreach($addresses as $address)
            <tr>
                <td scope="col">{{ $address->alias }} </td>
                <td scope="col">{{ $address->address_1 }} </td>
                <td scope="col">{{ $address->address_2 }} </td>
                <td scope="col">{{ $address->city }}</td>
                <td scope="col">{{ $address->country->name }}</td>
                <td scope="col">{{ $address->zip }}</td>
                <td scope="col">{{ $address->phone }}</td>
                <td scope="col">
                    <a href ='{{ route('addresses.edit', $address->id) }}' class="btn btn-sm btn-info">Edit</a>
                    <form method="POST" action='{{ route('addresses.destroy', $address->id) }}' style="cursor:pointer" class="btn btn-sm btn-danger deleteWithoutAjax">
                      @csrf @method('DELETE') Delete
                    </form>
                </td>
            </tr>
             @endforeach

          </tbody>
          
        </table>
        
      </div>

      <div class="col-4">
        <div class="card">
          <img src="{{ asset('public/frontend/images/kaziariyan.png') }}" class="card-img-top" style="height: 90px; width: 90px; margin-left: 34%;">
          <div class="card-body">
            <h5 class="card-title text-center">{{ Auth::user()->name }}</h5>
            
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"> <a href="{{ route('password.change') }}">Change Password</a> </li>
            <li class="list-group-item"> <a href="{{ route('addresses.index') }}">Addresses</a> </li>
            <li class="list-group-item">Edit Profile</li>
            <li class="list-group-item"><a href=""> Return Order</a> </li> 
          </ul>

          <div class="card-body">
            <a href="{{ route('user.logout') }}" class="btn btn-danger btn-sm btn-block">Logout</a>
            
          </div>
          
        </div>
        
      </div>

    </div>

  </div>
  

</div>





@endsection
