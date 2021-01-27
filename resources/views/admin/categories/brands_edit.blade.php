@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Edit Brand</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Edit Brand</h6>
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

        <form action ='{{ route('admin.brands.update', $brand->id) }}' method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body pd-20">
              <div class="form-group">
                <label for="exampleInputEmail1">Brand Name</label>
                <input type="text" class="form-control" name="brand_name" value="{{ $brand->brand_name }}">
              </div>
              <div class="form-group">
                <label class="d-block" for="exampleInputEmail1">Brand Logo</label>
                <label class="custom-file">
                  <input type="file" id="file" class="custom-file-input" name="brand_logo" onchange="preview_image(event)">
                  <span class="custom-file-control"></span>
                </label>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Brand Logo</label>
                <img id="output_image" src="{{ $brand->brand_logo }}" alt="" height="40" width="100">
              </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-info pd-x-20">Update</button>
            </div>
            
        </form>

          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script type='text/javascript'>
      function preview_image(event) 
      {
       var reader = new FileReader();
       reader.onload = function()
       {
        var output = document.getElementById('output_image');
        output.src = reader.result;
       }
       reader.readAsDataURL(event.target.files[0]);
      }
      </script>
      
@endsection