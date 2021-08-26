@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Edit Permission</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Edit Permission</h6>
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

        <form action ='{{ route('admin.permissions.update', $permission->id) }}' method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body pd-20">
              <div class="form-group">
                <label for="exampleInputEmail1">Permission Name</label>
                <input type="text" class="form-control" name="name" value="{{ $permission->name }}">
              </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-info pd-x-20">Update permission</button>
            </div>
            
        </form>

          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
      
@endsection