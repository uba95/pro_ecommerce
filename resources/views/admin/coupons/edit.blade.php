@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Edit Coupon</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Edit Coupon</h6>
          <div class="table-wrapper">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action ='{{ route('admin.coupons.update', $coupon->id) }}' method="POST">
            @csrf
            @method('PUT')
            <div class="pd-20">
              <div class="form-group">
                <label for="exampleInputEmail1">Coupon Code</label>
                <input type="text" class="form-control" name="coupon_name" value="{{ $coupon->coupon_name }}">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Discount Percentage %</label>
                <input type="number" class="form-control" name="discount" value="{{ $coupon->discount }}">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Max Use Count</label>
                <input type="number" class="form-control" name="max_use_count" min="0" value="{{ $coupon->max_use_count }}">
              </div>
              <div class="form-group">
                <div class="form-group d-flex justify-content-between">
                  <label class="ckbox">
                    <input name="status" type="hidden" value="inactive">
                    <input name="status" type="checkbox" value="active" {{ $coupon->status == 'active' ? 'checked' : '' }}>
                    <span>Active</span>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <div>Start At</div>
                <input type="date" class="form-control" name="started_at" value="{{ $coupon->started_at->isoFormat('Y-MM-DD') }}">
              </div>
              <div class="form-group">
                <div>Expire At</div>
                <input type="date" class="form-control" name="expired_at"  value="{{ $coupon->expired_at->isoFormat('Y-MM-DD') }}">
              </div>
            </div><!-- modal-body -->
            <div class="">
              <button type="submit" class="btn btn-info pd-x-20">Update</button>
            </div>
            
        </form>

          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
      
@endsection