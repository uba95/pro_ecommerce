@extends('layouts.admin.index')



@section('admin_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="index.html">Starlight</a>
    <span class="breadcrumb-item active">Product Section</span>
  </nav>

  <div class="sl-pagebody">
    <div class="card pd-20 pd-sm-40">

      <h6 class="card-body-title d-flex">
        <span class="mr-auto">Product Details Page</span>
        <a href='{{ route('admin.products.edit', $product->id) }}' class="btn btn-sm mr-1 btn-success">Edit Product</a>
        @if (!is_null($product->hotDeal))
        <a href='{{ route('admin.products.hot_deals.edit', $product->id) }}' class="btn btn-sm btn-success">Edit Hot
          Deal</a>
        @else
        <a href='{{ route('admin.products.hot_deals.create', $product->id) }}' class="btn btn-sm btn-success">Add Hot
          Deal</a>
        @endif
      </h6>

      <div id="accordion" class="accordion my-5" role="tablist" aria-multiselectable="true">
        <div class="card">
          <div class="card-header" role="tab" id="heading1">
            <h6 class="mg-b-0">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true"
                aria-controls="collapse1" class="tx-gray-800 transition">
                Name
              </a>
            </h6>
          </div><!-- card-header -->
          <div id="collapse1" class="collapse show" role="tabpanel" aria-labelledby="heading1">
            <div class="card-block pd-20">
              <label class="form-control-label">Product Name: </label><br>
              <h5><span class="badge badge-primary">{{  $product->product_name }}</span></h5>
              <label class="form-control-label">Product Slug: </label><br>
              <h5><span class="badge badge-primary">{{  $product->product_slug }}</span></h5>
              <label class="form-control-label">SKU: </label><br>
              <h5><span class="badge badge-primary">{{  $product->sku }}</span></h5>
            </div>
          </div>
        </div><!-- card -->

        <div class="card">
          <div class="card-header" role="tab" id="heading2">
            <h6 class="mg-b-0">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false"
                aria-controls="collapse2" class="tx-gray-800 collapsed transition">
                Category
              </a>
            </h6>
          </div><!-- card-header -->
          <div id="collapse2" class="collapse" role="tabpanel" aria-labelledby="heading2">
            <div class="card-block pd-20">
              <label class="form-control-label">Category: </label><br>
              <h5><span class="badge badge-primary">{{  $product->category->category_name }}</span></h5>
              <label class="form-control-label">Sub Category: </label><br>
              <h5><span class="badge badge-primary">{{  optional($product->subcategory)->subcategory_name }}</span></h5>
              <label class="form-control-label">Brand: </label>
              <h5><span class="badge badge-primary">{{  optional($product->brand)->brand_name }}</span></h5>
            </div>
          </div>
        </div><!-- card -->

        <div class="card">
          <div class="card-header" role="tab" id="heading3">
            <h6 class="mg-b-0">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false"
                aria-controls="collapse3" class="tx-gray-800 collapsed transition">
                Price
              </a>
            </h6>
          </div><!-- card-header -->
          <div id="collapse3" class="collapse" role="tabpanel" aria-labelledby="heading3">
            <div class="card-block pd-20">
              <label class="form-control-label">Selling Price: </label>
              <h5><span class="badge badge-primary">{{  $product->selling_price }}$</span></h5>
              <label class="form-control-label">Discount Price: </label><br>
              <h5><span class="badge badge-primary">{{  $product->discount_price }}$</span></h5>
            </div>
          </div>
        </div><!-- card -->

        <div class="card">
          <div class="card-header" role="tab" id="heading4">
            <h6 class="mg-b-0">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false"
                aria-controls="collapse4" class="tx-gray-800 collapsed transition">
                Attributes
              </a>
            </h6>
          </div><!-- card-header -->
          <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="heading4">
            <div class="card-block pd-20">
              <label class="form-control-label">Quantity: </label><br>
              <h5><span class="badge badge-primary">{{  $product->product_quantity }}</span></h5>

              <label class="form-control-label">Product Color: </label><br>
              @foreach ($product->product_color as $color)
              <h5 style="display: inline-block"><span class="badge badge-primary">{{ $color }}</span></h5>
              @endforeach <br>

              <label class="form-control-label">Product Size: </label><br>
              @foreach ($product->product_size ?? [] as $size)
              <h5 style="display: inline-block"><span class="badge badge-primary">{{ $size }}</span></h5>
              @endforeach
            </div>
          </div>
        </div><!-- card -->

        <div class="card">
          <div class="card-header" role="tab" id="heading5">
            <h6 class="mg-b-0">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false"
                aria-controls="collapse5" class="tx-gray-800 collapsed transition">
                Details
              </a>
            </h6>
          </div><!-- card-header -->
          <div id="collapse5" class="collapse" role="tabpanel" aria-labelledby="heading5">
            <div class="card-block pd-20">
              <p>{!! $product->product_details !!}</p>
            </div>
          </div>
        </div><!-- card -->

        <div class="card">
          <div class="card-header" role="tab" id="heading6">
            <h6 class="mg-b-0">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false"
                aria-controls="collapse6" class="tx-gray-800 collapsed transition">
                Other
              </a>
            </h6>
          </div><!-- card-header -->
          <div id="collapse6" class="collapse" role="tabpanel" aria-labelledby="heading6">
            <div class="card-block pd-20">
              <label class="form-control-label">Video Link: </label><br>
              <h5><span class="badge badge-primary">{{  $product->video_link }}</span></h5>
            </div>
          </div>
        </div><!-- card -->

      </div><!-- accordion -->

      <div class="form-layout"><hr>
        <div class="row mg-b-25">
          <div class="col-lg-3 mg-t-25 mg-lg-t-0">
            <div class="card pd-20 pd-sm-40">
              <div class="card">
                <div class="card-body bd bd-b-0">
                  <h6 class="mg-b-3 text-center"><a class="tx-darkr">Cover</a></h6>
                </div><!-- card-body -->
                <img class="card-img-bottom img-fluid" src="{{ $product->cover }}" alt="Image" style="background-color: #eee;">
              </div><!-- card -->
            </div><!-- card -->
          </div><!-- col-6 -->

          @foreach ($product->images as $k => $img)
          <div class="col-lg-3 mg-t-25 mg-lg-t-0">
            <div class="card pd-20 pd-sm-40">
              <div class="card">
                <div class="card-body bd bd-b-0">
                  <h6 class="mg-b-3 text-center"><a class="tx-dark">Images {{ $k+1 }}</a></h6>
                </div><!-- card-body -->
                <img class="card-img-bottom img-fluid" src="{{ URL::to($img->name) }}" alt="Image" style="background-color: #eee;">
              </div><!-- card -->
            </div><!-- card -->
          </div><!-- col-6 -->
          @endforeach
        </div><!-- row -->        
      </div><!-- form-layout -->

    </div><!-- card -->
  </div><!-- row -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
@endsection