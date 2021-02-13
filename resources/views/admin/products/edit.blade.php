@extends('admin.admin_layouts')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Ecommmerce</a>
        <span class="breadcrumb-item active">Update Product</span>
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
          <h6 class="card-body-title">Update Product</h6>
          <p class="mg-b-20 mg-sm-b-30">Update Product Form</p>

          <form action='{{ route('admin.products.update', $product->id) }}' method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-layout">
              <div class="row mg-b-25">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Name <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="product_name" value="{{ $product->product_name }}">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Code <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="product_code" value="{{ $product->product_code }}">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Quantity <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="product_quantity" value="{{ $product->product_quantity }}">
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Discount Price</label><br>
                    <input class="form-control" type="text" name="discount_price" value="{{ $product->discount_price }}">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Selling Price <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="selling_price" value="{{ $product->selling_price }}">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Video Link </label>
                    <input class="form-control" type="text" name="video_link" value="{{ $product->video_link }}">
                  </div>
                </div><!-- col-4 -->

                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Size <span class="tx-danger">*</span></label>
                    <select class="form-control select2-tag" name="product_size[]" multiple>
                      @foreach ($product->product_size ?? [] as $size)
                        <option value="{{ $size }}" data-select2-tag="true" selected>
                          {{ $size }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">Color <span class="tx-danger">*</span></label>
                    <select class="form-control select2-tag" name="product_color[]" multiple>
                      @foreach ($product->product_color as $color)
                        <option value="{{ $color }}" data-select2-tag="true" selected>
                          {{ $color }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- col-4 -->

                <div class="col-lg-4">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Category </label>
                    <select name="category_id" class="form-control select2 select2_empty" data-placeholder="Choose Category">
                      <option label="Category country"></option>
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id === $category->id ? 'selected' : '' }}>
                          {{ $category->category_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Subcategory </label>
                    <select name="subcategory_id" class="form-control select2 select2_empty" data-placeholder="Choose Subcategory">
                      <option label="Choose Subcategory"></option>
                      @foreach ($product->category->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ $product->subcategory_id === $subcategory->id ? 'selected' : '' }}>
                          {{ $subcategory->subcategory_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group mg-b-10-force">
                    <label class="form-control-label">Brand </label>
                    <select name="brand_id" class="form-control select2 select2_empty" data-placeholder="Choose Brand">
                      <option label="Choose Brand"></option>
                      @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id === $brand->id ? 'selected' : '' }}>
                          {{ $brand->brand_name }}
                        </option>
                     @endforeach
                    </select>
                  </div>
                </div><!-- col-4 -->
                
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">Details <span class="tx-danger">*</span></label>
                    <textarea name="product_details" class="form-control" id="summernote">{{ $product->product_details }}</textarea>
                  </div>
                </div><!-- col-4 -->
              </div><!-- row -->
  
              <hr>

              <div class="row mg-b-25">
                <div class="col-lg-4">
                    <label class="ckbox">
                      <input type="checkbox" name="main_slider" value="1" {{ $product->main_slider ? 'checked' : '' }}>
                      <span>Main Slider</span>
                    </label>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <label class="ckbox">
                      <input type="checkbox" name="hot_deal" value="1" {{ $product->hot_deal ? 'checked' : '' }}>
                      <span>Hot Deal</span>
                    </label>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <label class="ckbox">
                      <input type="checkbox" name="best_rated" value="1" {{ $product->best_rated ? 'checked' : '' }}>
                      <span>Best Rated</span>
                    </label>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <label class="ckbox">
                      <input type="checkbox" name="mid_slider" value="1" {{ $product->mid_slider ? 'checked' : '' }}>
                      <span>Mid Slider</span>
                    </label>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <label class="ckbox">
                      <input type="checkbox" name="hot_new" value="1" {{ $product->hot_new ? 'checked' : '' }}>
                      <span>Hot new</span>
                    </label>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                    <label class="ckbox">
                      <input type="checkbox" name="trend" value="1" {{ $product->trend ? 'checked' : '' }}>
                      <span>Trend</span>
                    </label>
                </div><!-- col-4 -->
              </div><!-- row -->

              <hr>

              <div class="row  mg-b-25">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Image 1 <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" class="custom-file-input" name="image_one" onchange="readURL(this)">
                      <span class="custom-file-control"></span>
                      <img class="mg-t-25" src="{{ $product->image_one }}" alt="" id="image_one" style="height: 80px; width: 80px;">
                    </label>
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Image 2 <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" class="custom-file-input" name="image_two" onchange="readURL(this)">
                      <span class="custom-file-control"></span>
                      <img class="mg-t-25" src="{{ $product->image_two }}" alt="" id="image_two" style="height: 80px; width: 80px;">
                    </label>
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Image 3 <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" class="custom-file-input" name="image_three" onchange="readURL(this)">
                      <span class="custom-file-control"></span>
                      <img class="mg-t-25" src="{{ $product->image_three }}" alt="" id="image_three" style="height: 80px; width: 80px;">
                    </label>
                  </div>
                </div><!-- col-4 -->
              </div><!-- row -->

              <div class="form-layout-footer">
                <button class="btn btn-info mg-r-5 mg-t-50">Update Product</button>
              </div><!-- form-layout-footer -->
            </div><!-- form-layout -->  
          </form>

        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    @push('scripts')
      <script type="text/javascript">
        $(document).ready(function(){
          $(document).on('change', 'select[name="category_id"]',function(){
              var category_id = $(this).val();
              if (category_id) {
                
                $.ajax({
                  url: `/admin/categories/${category_id}`,
                  type:"GET",
                  dataType:"json",
                  success:function(data) { 
                    var d = $('select[name="subcategory_id"]');
                    d.empty();
                    data.message ? toastr.error(data.message) :
                    data.forEach( (value) => d.append(`<option value="${value.id}">${value.subcategory_name}</option>`) );
                  },
                });
              }
            });
          });
      </script>

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
