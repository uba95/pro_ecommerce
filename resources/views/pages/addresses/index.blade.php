@extends('layouts.home')

@section('button')
  <a href ='{{ route('addresses.create') }}' class="btn btn-success mb-3" style="">Add New Address</a>
@endsection

@section('section')

      <div class="col-lg-8 card">
        <table class="table table-responsive d-lg-table">
          <thead>
            <tr>
              <th scope="col">Alias</th>
              <th scope="col">Address 1</th>
              <th scope="col">Address 2 </th>
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
                <td scope="col">{{ $address->phone }}</td>
                <td class="col d-flex">
                  <a class="btn btn-sm btn-info mr-1" href ='{{ route('addresses.edit', $address->id) }}' title="Edit Address" ><i class="fa fa-edit fa-fw"></i></a>
                  <form method="POST" action='{{ route('addresses.destroy', $address->id) }}' class="deleteWithoutAjax">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" title="Delete Address">
                      <span class="fa fa-times fa-fw"></span>
                      </button>
                  </form>
                </td>
            </tr>
             @endforeach

          </tbody>
        </table>
      </div>
@endsection
