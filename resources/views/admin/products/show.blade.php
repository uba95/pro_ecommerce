@extends('admin.admin_layouts')

 

@section('admin_content')
  <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="index.html">Starlight</a>
        <span class="breadcrumb-item active">Product Section</span>
      </nav>

      <div class="sl-pagebody">


 <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Product Details Page
            <a href='{{ route('admin.products.edit', $product->id) }}' class="btn btn-sm btn-success float-right">Edit Product</a>
          </h6>

          <div class="form-layout">
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Product Name: </label><br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->product_name }}</span></h5>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Product Code: </label><br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->product_code }}</span></h5>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Quantity: </label><br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->product_quantity }}</span></h5>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Discount Price: </label><br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->discount_price }}</span></h5>
                </div>
              </div><!-- col-4 -->
               
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Category: </label><br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->category->category_name }}</span></h5>
                </div>
              </div><!-- col-4 -->


              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Sub Category: </label><br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->subcategory->subcategory_name }}</span></h5>
                </div>
              </div><!-- col-4 -->



              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Brand: </label>
                  <br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->brand->brand_name }}</span></h5>
                </div>
              </div><!-- col-4 -->


              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Product Size: </label>
                    <br>
                  @foreach ($product->product_size as $size)
                    <h5 style="display: inline-block"><span class="badge badge-primary">{{ $size }}</span></h5>
                  @endforeach
                </div>
              </div><!-- col-4 -->

              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Product Color: </label>
                    <br>
                    @foreach ($product->product_color as $color)
                      <h5 style="display: inline-block"><span class="badge badge-primary">{{ $color }}</span></h5>
                    @endforeach
                </div>
              </div><!-- col-4 -->

              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Selling Price: </label>
                  <br>
                  <h5 style="display: inline-block"><span class="badge badge-primary">{{  $product->selling_price }}</span></h5>
                </div>
              </div><!-- col-4 -->


               <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Product Details: </label>
                  <br>
                 <p>   {!! $product->product_details !!} </p>
    
                </div>
              </div><!-- col-4 -->

                <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Video Link: </label>
                  <br>
                  <strong>{{ $product->video_link }}</strong>
                   
                </div>
              </div><!-- col-4 -->



 <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Image One ( Main Thumbnali): </label><br>
                 <label class="custom-file">
           
            <img src="{{ URL::to($product->image_one) }}" style="height: 80px; width: 80px;">
            </label>

                </div>
              </div><!-- col-4 -->


               <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Image Two: </label><br>
                 <label class="custom-file">
           <img src="{{ URL::to($product->image_two) }}" style="height: 80px; width: 80px;">
            </label>

                </div>
              </div><!-- col-4 -->




 <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Image Three: </label><br>
                 <label class="custom-file">
           <img src="{{ URL::to($product->image_three) }}" style="height: 80px; width: 80px;">

            </label>

                </div>
              </div><!-- col-4 --> 

            </div><!-- row -->

  <hr>
  <br><br>

          <div class="row">

        <div class="col-lg-4">
        <label class="">
         @if($product->main_slider == 1)
         <span class="badge badge-success">Active</span>

         @else
       <span class="badge badge-danger">Inactive</span>
         @endif 

          <span>Main Slider</span>
        </label>

        </div> <!-- col-4 --> 

         <div class="col-lg-4">
        <label class="">
         @if($product->hot_deal == 1)
         <span class="badge badge-success">Active</span>

         @else
       <span class="badge badge-danger">Inactive</span>
         @endif 
          
          <span>Hot Deal</span>
        </label>

        </div> <!-- col-4 --> 



         <div class="col-lg-4">
       <label class="">
         @if($product->best_rated == 1)
         <span class="badge badge-success">Active</span>

         @else
       <span class="badge badge-danger">Inactive</span>
         @endif 
          
          <span>Best Rated</span>
        </label>

        </div> <!-- col-4 --> 


         <div class="col-lg-4">
       <label class="">
         @if($product->trend == 1)
         <span class="badge badge-success">Active</span>

         @else
       <span class="badge badge-danger">Inactive</span>
         @endif 
        
          <span>Trend Product </span>
        </label>

        </div> <!-- col-4 --> 

 <div class="col-lg-4">
        <label class="">
         @if($product->mid_slider == 1)
         <span class="badge badge-success">Active</span>

         @else
       <span class="badge badge-danger">Inactive</span>
         @endif 
          
          <span>Mid Slider</span>
        </label>

        </div> <!-- col-4 --> 

<div class="col-lg-4">
       <label class="">
         @if($product->hot_new == 1)
         <span class="badge badge-success">Active</span>

         @else
       <span class="badge badge-danger">Inactive</span>
         @endif 
          
          <span>Hot New </span>
        </label>

        </div> <!-- col-4 --> 
 

          </div><!-- end row --> 
 
 

            
          </div><!-- form-layout -->
        </div><!-- card -->
 
        
        </div><!-- row -->

  
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
 
 

 

 
@endsection
