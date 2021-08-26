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
            @can('create coupons')
              <a href="" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modaldemo3">Add New Coupon</a>
            @endcan
          </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Coupon ID</th>
                  <th class="wd-15p">Coupon Code</th>
                  <th class="wd-15p">Discount Percentage %</th>
                  <th class="wd-15p">Use Count</th>
                  <th class="wd-15p">Max Use Count</th>
                  <th class="wd-15p">Status</th>
                  <th class="wd-15p">Start At</th>
                  <th class="wd-15p">Expire At</th>
                  @canany(['edit coupons', 'delete coupons'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($coupons as $key => $coupon)
                    <tr>
                        <td>{{ $coupon->id }}</td>
                        <td>{{ $coupon->coupon_name }}</td>
                        <td>{{ $coupon->discount }}%</td>
                        <td>{{ $coupon->use_count }}</td>
                        <td>{{ $coupon->max_use_count }}</td>
                        <td>
                        @switch($coupon->status)
                        @case('inactive')
                            <span class="badge badge-dark">INACTIVE</span>
                            @break
                        @case('active')
                            <span class="badge badge-success">ACTIVE</span>
                            @break
                        @case('expired')
                            <span class="badge badge-danger">EXPIRED</span>
                            @break
                        @endswitch
                        </td>
                        <td>{{ $coupon->started_at->isoFormat('Y-MM-DD') }}</td>
                        <td>{{ $coupon->expired_at->isoFormat('Y-MM-DD') }}</td>
                        @canany(['edit coupons', 'delete coupons'])
                          <td>
                            @can('edit coupons')
                              <a href ='{{ route('admin.coupons.edit', $coupon->id) }}' class="btn btn-sm btn-info">Edit</a>
                            @endcan
                            @can('delete coupons')
                              <form method="POST" action='{{ route('admin.coupons.destroy', $coupon->id) }}' class="btn btn-sm btn-danger delete">
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
    @can('create coupons')
      <!-- LARGE MODAL -->
      <div id="modaldemo3" class="modal fade">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
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
                            <input type="number" class="form-control" name="discount" min="0" max="100" value="0">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Max Use Count</label>
                            <input type="number" class="form-control" name="max_use_count" min="0" value="0">
                          </div>
                          <div class="form-group">
                            <label class="ckbox">
                              <input name="status" type="checkbox" value="active" checked>
                              <span>Active</span>
                            </label>
                          </div>
                          <div class="form-group">
                            <div>Start At</div>
                            <input type="date" class="form-control" name="started_at">
                          </div>
                          <div class="form-group">
                            <div>Expire At</div>
                            <input type="date" class="form-control" name="expired_at">
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