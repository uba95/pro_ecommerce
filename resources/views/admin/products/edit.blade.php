@extends('layouts.admin.index')

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
                    <label class="form-control-label">SKU <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="sku" value="{{ $product->sku }}">
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

                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Meta Title</label><br>
                    <input class="form-control" type="text" name="meta_title" value="{{ optional($product->meta)->meta_title }}">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Meta Keywords</label>
                    <input class="form-control" type="text" name="meta_keywords" value="{{ optional($product->meta)->meta_keywords }}">
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Meta Descrition</label>
                    <input class="form-control" type="text" name="meta_description" value="{{ optional($product->meta)->meta_description }}">
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
                      @foreach ($categories as $id => $category_name))
                        <option value="{{ $id }}" {{ $product->category_id === $id ? 'selected' : '' }}>
                          {{ $category_name }}
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
                      @foreach ($brands as $id => $brand_name)
                        <option value="{{ $id }}" {{ $product->brand_id === $id ? 'selected' : '' }}>
                          {{ $brand_name }}
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

              <div class="row  mg-b-25">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Cover <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" class="custom-file-input" name="cover" onchange="readURL(this)">
                      <span class="custom-file-control"></span>
                      <img class="mg-t-25" src="{{ $product->cover }}" alt="" id="cover" style="height: 80px; width: 80px;">
                    </label>
                  </div>
                </div><!-- col-4 -->
                <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-control-label">Images <span class="tx-danger">*</span></label>
                    <label class="custom-file">
                      <input type="file" class="custom-file-input" name="image[]" onchange="readURL(this)" multiple>
                      <span class="custom-file-control"></span>
                    </label>
                  </div>
                </div><!-- col-4 -->
              </div><!-- row -->

              <div class="row mt-5">
                <div class="col-lg-4">
                  <label class="ckbox">
                    <input name="status" type="hidden" value="inactive">
                    <input name="status" type="checkbox" value="active" {{ $product->status->isActive() ? 'checked' : '' }}>
                    <span>Active</span>
                  </label>
                      </div><!-- col-4 -->
              </div>

              <div class="form-layout-footer">
                <button class="btn btn-info mg-r-5 mg-t-50">Update Product</button>
              </div><!-- form-layout-footer -->
            </div><!-- form-layout -->  
          </form>
          <h6 class="my-5">Product Images</h4>
          <div class="d-flex mt-2 justify-content-between">
            @foreach ($product->images as $img)
              <div class="pos-relative"  style="height: 200px; width: 200px;">
                <img class="w-100 h-100 " src="{{ $img->name }}" alt="">
                <form method="POST" action='{{ route('admin.products.images.destroy', $img->id) }}' class="delete" style="position: absolute; left: 0; bottom: 0;">
                  @csrf @method('DELETE')
                  <i class=" btn btn-sm btn-danger fa fa-trash fa-fw p-0" title="delete"></i>
                </form>
              </div>  
            @endforeach
          </div>


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
          if (input.files) {
            $(input).siblings('img').remove();
            Array.from(input.files).forEach(function (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
              $(input).parent().append(`<img class="mg-t-25" src="${e.target.result}" width= "80" height= "80">`)
            };
            reader.readAsDataURL(file);
            });
          }
        }
      </script>
  @endpush
@endsection
