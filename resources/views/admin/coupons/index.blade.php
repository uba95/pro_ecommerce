@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Coupons Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Coupons List
            <a href="" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modaldemo3">Add New Coupon</a>
          </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Coupon ID</th>
                  <th class="wd-15p">Coupon Code</th>
                  <th class="wd-15p">Discount Percentage %</th>
                  <th class="wd-20p">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($coupons as $key => $coupon)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $coupon->coupon_name }}</td>
                        <td>{{ $coupon->discount }}%</td>
                        <td>
                            <a href ='{{ route('admin.coupons.edit', $coupon->id) }}' class="btn btn-sm btn-info">Edit</a>
                            <a href ='{{ route('admin.coupons.delete', $coupon->id) }}' class="btn btn-sm btn-danger" id="delete">Delete</a>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

            <!-- LARGE MODAL -->
            <div id="modaldemo3" class="modal fade">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header pd-x-20">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Coupon</h6>
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

                        <form action ='{{ route('admin.coupons.store') }}' method="POST">
                            @csrf
                            <div class="modal-body pd-20">
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Coupon Code</label>
                                  <input type="text" class="form-control" name="coupon_name">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Discount Percentage %</label>
                                  <input type="number" class="form-control" name="discount">
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
      
@endsection