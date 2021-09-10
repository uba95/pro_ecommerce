@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Ecommmerce</a>
        <span class="breadcrumb-item active">Blog Section</span>
      </nav>

      @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="mg-t-10"><strong>{{ $error }}</strong></li>
                @endforeach
            </ul>
        </div>
      @endif

      <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Edit Post</h6>
          <p class="mg-b-20 mg-sm-b-30">Edit Post Form</p>

          <form action='{{ route('admin.blog_posts.update', $blogPost->id) }}' method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-layout">
              <div class="row mg-b-25">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Title <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="post_title" value="{{ $blogPost->post_title }}">
                  </div>
                </div><!-- col-4 -->

                <div class="col-lg-6">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Category</label>
                    <select name="category_id" class="form-control select2 select2_empty" data-placeholder="Choose Category">
                      <option></option>
                      @foreach ($categories as $id => $blog_category_name))
                        <option value="{{ $id }}" {{ $blogPost->category_id === $id ? 'selected' : '' }}>
                          {{ $blog_category_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- col-4 -->
    
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">Details <span class="tx-danger">*</span></label>
                    <textarea name="details" class="form-control" id="summernote">{{ $blogPost->details }}</textarea>
                  </div>
                </div><!-- col-4 -->
              </div><!-- row -->
  
              <hr>

              <div class="row  mg-b-25">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Image <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" class="custom-file-input" name="post_image" onchange="readURL(this)">
                      <span class="custom-file-control"></span>
                      <img  class="mg-t-25" src="{{ $blogPost->post_image }}" alt="" id="post_image" height="80" width="100">
                    </label>
                  </div>
                </div><!-- col-4 -->
              </div><!-- row -->

              <div class="form-layout-footer">
                <button class="btn btn-info mg-r-5 mg-t-50 ">Add Post</button>
              </div><!-- form-layout-footer -->
            </div><!-- form-layout -->  
          </form>

        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    @push('scripts')
      <script type="text/javascript">
        function readURL(input){
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = (e) => $('#' + input.name).attr('src', e.target.result).width(80).height(80);
            reader.readAsDataURL(input.files[0]);
          }
        }
      </script>
  @endpush
@endsection
