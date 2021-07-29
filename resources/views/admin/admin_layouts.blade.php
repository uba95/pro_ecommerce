<!DOCTYPE html>
<html lang="en">
  <head>
    @stack('styles')
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Admin Panel</title>

    <!-- vendor css -->
    <link href="{{asset('backend/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">

    <!-- toastr -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
   
    <!-- Datatable -->
    <link href="{{asset('backend/lib/highlightjs/github.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/datatables/jquery.dataTables.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/select2/css/select2.min.css')}}" rel="stylesheet">

    <!-- Forms -->
    <link href="{{asset('backend/lib/spectrum/spectrum.css')}}" rel="stylesheet">
    <link href="{{asset('backend/lib/summernote/summernote-bs4.css')}}" rel="stylesheet">

    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{asset('backend/css/starlight.css')}}">
  </head>

  <body>

  @auth('admin')

    <!-- ########## START: LEFT PANEL ########## -->
    <div class="sl-logo"><a href='{{ url('admin/home') }}'><i class="icon ion-android-star-outline"></i> Ecommmerce</a></div>
    <div class="sl-sideleft">
      <div class="sl-sideleft-menu">
        <a href='{{ url('admin/home') }}' class="sl-menu-link active">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
            <span class="menu-item-label">Dashboard</span>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->

        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon ion-ios-pie-outline tx-20"></i>
            <span class="menu-item-label">Categories</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.categories.index') }}' class="nav-link">Categories</a></li>
          <li class="nav-item"><a href ='{{ route('admin.subcategories.index') }}' class="nav-link">Subcategories</a></li>
          <li class="nav-item"><a href ='{{ route('admin.brands.index') }}' class="nav-link">Brands</a></li>
        </ul>

        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Products</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.products.index') }}' class="nav-link">All Products</a></li>
          <li class="nav-item"><a href ='{{ route('admin.products.create') }}' class="nav-link">Add New Product</a></li>
        </ul>

        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Orders</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.orders.index') }}' class="nav-link">All Orders</a></li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'pending']) }}' class="nav-link">
              Pending
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'paid']) }}' class="nav-link">
              Paid
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'shipped']) }}' class="nav-link">
              Shipped
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'delivered']) }}' class="nav-link">
              Delivred
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'canceled']) }}' class="nav-link">
              Canceled
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'returning']) }}' class="nav-link">
            Returning
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.orders.index', ['status' => 'returned']) }}' class="nav-link">
              Returned
            </a>
          </li>
        </ul>


        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Cancel Order Requests</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.cancel_orders.index') }}' class="nav-link">All Cancel Requests</a></li>
          <li class="nav-item">
            <a href ='{{ route('admin.cancel_orders.index', ['status' => 'pending']) }}' class="nav-link">
              Pending
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.cancel_orders.index', ['status' => 'approved']) }}' class="nav-link">
              Approved
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.cancel_orders.index', ['status' => 'refunded']) }}' class="nav-link">
              Refunded
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.cancel_orders.index', ['status' => 'rejected']) }}' class="nav-link">
              Rejected
            </a>
          </li>
        </ul>

        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Return Order Requests</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.return_orders.index') }}' class="nav-link">All Return Requests</a></li>
          <li class="nav-item">
            <a href ='{{ route('admin.return_orders.index', ['status' => 'pending']) }}' class="nav-link">
              Pending
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.return_orders.index', ['status' => 'approved']) }}' class="nav-link">
              Approved
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.return_orders.index', ['status' => 'shipped']) }}' class="nav-link">
              Shipped
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.return_orders.index', ['status' => 'returned']) }}' class="nav-link">
              Returned
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.return_orders.index', ['status' => 'refunded']) }}' class="nav-link">
              Refunded
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.return_orders.index', ['status' => 'rejected']) }}' class="nav-link">
              Rejected
            </a>
          </li>
        </ul>


        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Stocks</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item">
            <a href ='{{ route('admin.stocks.index') }}' class="nav-link">
              All Stocks
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.stocks.index', ['status' => 'in']) }}' class="nav-link">
             In Stock
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.stocks.index', ['status' => 'only']) }}' class="nav-link">
              Few Left
            </a>
          </li>
          <li class="nav-item">
            <a href ='{{ route('admin.stocks.index', ['status' => 'out']) }}' class="nav-link">
              Out Of Stock
            </a>
          </li>
        </ul>



        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Blog</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.blog_categories.index') }}' class="nav-link">Blog Categories</a></li>
          <li class="nav-item"><a href ='{{ route('admin.blog_posts.index') }}' class="nav-link">Blog Posts</a></li>
          <li class="nav-item"><a href ='{{ route('admin.blog_posts.create') }}' class="nav-link">Add New Post</a></li>
        </ul>


        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Reports</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item">
            <a href ='{{ route('admin.reports.salesBy') }}' class="nav-link">Sales By Products</a>
            <a href ='{{ route('admin.reports.index', ['report' => 'sales']) }}' class="nav-link">Sales</a>
            <a href ='{{ route('admin.reports.index', ['report' => 'returns']) }}' class="nav-link">Returns</a>
            <a href ='{{ route('admin.reports.index', ['report' => 'net_sales']) }}' class="nav-link">Net Sales</a>
            <a href ='{{ route('admin.reports.index', ['report' => 'orders']) }}' class="nav-link">Orders</a>
            <a href ='{{ route('admin.reports.index', ['report' => 'sold_products']) }}' class="nav-link">Sold Products</a>
            <a href ='{{ route('admin.reports.index', ['report' => 'others']) }}' class="nav-link">Others</a>
          </li>
        </ul>


        <a href="#" class="sl-menu-link">
          <div class="sl-menu-item">
            <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
            <span class="menu-item-label">Others</span>
            <i class="menu-item-arrow fa fa-angle-down"></i>
          </div><!-- menu-item -->
        </a><!-- sl-menu-link -->
        <ul class="sl-menu-sub nav flex-column">
          <li class="nav-item"><a href ='{{ route('admin.coupons.index') }}' class="nav-link">Coupons</a></li>
          <li class="nav-item"><a href ='{{ route('admin.newslaters.index') }}' class="nav-link">Newslaters</a></li>
        </ul>

      </div><!-- sl-sideleft-menu -->

      <br>
    </div><!-- sl-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="sl-header">
      <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
      </div><!-- sl-header-left -->
      <div class="sl-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name">Jane<span class="hidden-md-down"> Doe</span></span>
              <img src="{{asset('backend/img/img3.jpg')}}" class="wd-32 rounded-circle" alt="">

            </a>
            <div class="dropdown-menu dropdown-menu-header wd-200">
              <ul class="list-unstyled user-profile-nav">
                <li><a href=""><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
                <li><a href='{{ route('admin.password.change') }}'><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
                <li><a href="{{ route('admin.logout') }}"><i class="icon ion-power"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
        <div class="navicon-right">
          <a id="btnRightMenu" href="" class="pos-relative">
            <i class="icon ion-ios-bell-outline"></i>
            <!-- start: if statement -->
            <span class="square-8 bg-danger"></span>
            <!-- end: if statement -->
          </a>
        </div><!-- navicon-right -->
      </div><!-- sl-header-right -->
    </div><!-- sl-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <div class="sl-sideright">
      <ul class="nav nav-tabs nav-fill sidebar-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" href="#messages">Messages (2)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#notifications">Notifications (8)</a>
        </li>
      </ul><!-- sidebar-tabs -->

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane pos-absolute a-0 mg-t-60 active" id="messages" role="tabpanel">
          <div class="media-list">
            <!-- loop starts here -->
            <a href="" class="media-list-link">
              <div class="media">
                <img src="../img/img3.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Donna Seay</p>
                  <span class="d-block tx-11 tx-gray-500">2 minutes ago</span>
                  <p class="tx-13 mg-t-10 mg-b-0">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring.</p>
                </div>
              </div><!-- media -->
            </a>
            <!-- loop ends here -->
            <a href="" class="media-list-link">
              <div class="media">
                <img src="../img/img4.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Samantha Francis</p>
                  <span class="d-block tx-11 tx-gray-500">3 hours ago</span>
                  <p class="tx-13 mg-t-10 mg-b-0">My entire soul, like these sweet mornings of spring.</p>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link">
              <div class="media">
                <img src="../img/img7.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Robert Walker</p>
                  <span class="d-block tx-11 tx-gray-500">5 hours ago</span>
                  <p class="tx-13 mg-t-10 mg-b-0">I should be incapable of drawing a single stroke at the present moment...</p>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link">
              <div class="media">
                <img src="../img/img5.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Larry Smith</p>
                  <span class="d-block tx-11 tx-gray-500">Yesterday, 8:34pm</span>

                  <p class="tx-13 mg-t-10 mg-b-0">When, while the lovely valley teems with vapour around me, and the meridian sun strikes...</p>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link">
              <div class="media">
                <img src="../img/img3.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="mg-b-0 tx-medium tx-gray-800 tx-13">Donna Seay</p>
                  <span class="d-block tx-11 tx-gray-500">Jan 23, 2:32am</span>
                  <p class="tx-13 mg-t-10 mg-b-0">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring.</p>
                </div>
              </div><!-- media -->
            </a>
          </div><!-- media-list -->
          <div class="pd-15">
            <a href="" class="btn btn-secondary btn-block bd-0 rounded-0 tx-10 tx-uppercase tx-mont tx-medium tx-spacing-2">View More Messages</a>
          </div>
        </div><!-- #messages -->

        <div class="tab-pane pos-absolute a-0 mg-t-60 overflow-y-auto" id="notifications" role="tabpanel">
          <div class="media-list">
            <!-- loop starts here -->
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img8.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                  <span class="tx-12">October 03, 2017 8:45am</span>
                </div>
              </div><!-- media -->
            </a>
            <!-- loop ends here -->
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img9.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Mellisa Brown</strong> appreciated your work <strong class="tx-medium tx-gray-800">The Social Network</strong></p>
                  <span class="tx-12">October 02, 2017 12:44am</span>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img10.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700">20+ new items added are for sale in your <strong class="tx-medium tx-gray-800">Sale Group</strong></p>
                  <span class="tx-12">October 01, 2017 10:20pm</span>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img5.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Julius Erving</strong> wants to connect with you on your conversation with <strong class="tx-medium tx-gray-800">Ronnie Mara</strong></p>
                  <span class="tx-12">October 01, 2017 6:08pm</span>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img8.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Suzzeth Bungaos</strong> tagged you and 12 others in a post.</p>
                  <span class="tx-12">September 27, 2017 6:45am</span>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img10.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700">10+ new items added are for sale in your <strong class="tx-medium tx-gray-800">Sale Group</strong></p>
                  <span class="tx-12">September 28, 2017 11:30pm</span>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img9.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Mellisa Brown</strong> appreciated your work <strong class="tx-medium tx-gray-800">The Great Pyramid</strong></p>
                  <span class="tx-12">September 26, 2017 11:01am</span>
                </div>
              </div><!-- media -->
            </a>
            <a href="" class="media-list-link read">
              <div class="media pd-x-20 pd-y-15">
                <img src="../img/img5.jpg" class="wd-40 rounded-circle" alt="">
                <div class="media-body">
                  <p class="tx-13 mg-b-0 tx-gray-700"><strong class="tx-medium tx-gray-800">Julius Erving</strong> wants to connect with you on your conversation with <strong class="tx-medium tx-gray-800">Ronnie Mara</strong></p>
                  <span class="tx-12">September 23, 2017 9:19pm</span>
                </div>
              </div><!-- media -->
            </a>
          </div><!-- media-list -->
        </div><!-- #notifications -->

      </div><!-- tab-content -->
    </div><!-- sl-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

  @endauth

@yield('admin_content')

    <script src="{{asset('backend/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('backend/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('backend/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('backend/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    @stack('scripts')
    <script src="{{asset('backend/lib/highlightjs/highlight.pack.js')}}"></script>
    <script src="{{asset('backend/lib/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/lib/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('backend/lib/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('backend/lib/spectrum/spectrum.js')}}"></script>
    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
          }
        });

        $('#datatable2').DataTable({
          bLengthChange: false,
          searching: false,
          responsive: true
        });

        // Select2
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

      });
    </script>


<script>
  $(function(){

    'use strict';

    $('.select2').select2({
      minimumResultsForSearch: Infinity
    });

    // Select2 by showing the search
    $('.select2-show-search').select2({
      minimumResultsForSearch: ''
    });

    // Select2 with tagging support
    $('.select2-tag').select2({
      tags: true,
      tokenSeparators: [',', ' '],
    });

    $('.select2-tag').on('select2:open select2:opening', function( event ) {
      $('.select2-results').css('display', 'none');
    });

    $("#select2insidemodal").select2({
    dropdownParent: $("#modaldemo3")
    });

    $(".select2_empty").select2({
      allowClear: true,
    });

    // Datepicker
    $('.fc-datepicker').datepicker({
      dateFormat: "dd/mm/yy"   
     });

    // Color picker
    $('#colorpicker').spectrum({
      color: '#17A2B8'
    });

    $('#showAlpha').spectrum({
      color: 'rgba(23,162,184,0.5)',
      showAlpha: true
    });

    $('#showPaletteOnly').spectrum({
        showPaletteOnly: true,
        showPalette:true,
        color: '#DC3545',
        palette: [
            ['#1D2939', '#fff', '#0866C6','#23BF08', '#F49917'],
            ['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
        ]
    });

  });
</script>


<script src="{{asset('backend/lib/medium-editor/medium-editor.js')}}"></script>
<script src="{{asset('backend/lib/summernote/summernote-bs4.min.js')}}"></script>

<script>
  $(function(){
    'use strict';

    // Inline editor
    var editor = new MediumEditor('.editable');

    // Summernote editor
    $('#summernote').summernote({
      height: 150,
      tooltip: false
    })
  });
</script>

    <script src="{{asset('backend/lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('backend/lib/d3/d3.js')}}"></script>
    <script src="{{asset('backend/lib/rickshaw/rickshaw.min.js')}}"></script>
    <script src="{{asset('backend/lib/chart.js/Chart.js')}}"></script>
    <script src="{{asset('backend/lib/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('backend/lib/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('backend/lib/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('backend/lib/flot-spline/jquery.flot.spline.js')}}"></script>

    <script src="{{asset('backend/js/starlight.js')}}"></script>
    <script src="{{asset('backend/js/ResizeSensor.js')}}"></script>
    {{-- <script src="{{asset('backend/js/dashboard.js')}}"></script> --}}
    @stack('charts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>


    <script>
        @if(Session::has('message'))
          var type="{{Session::get('alert-type','info')}}"
          switch(type){
              case 'info':
                   toastr.info("{{ Session::get('message') }}");
                   break;
              case 'success':
                  toastr.success("{{ Session::get('message') }}");
                  break;
              case 'warning':
                 toastr.warning("{{ Session::get('message') }}");
                  break;
              case 'error':
                  toastr.error("{{ Session::get('message') }}");
                  break;
          }
        @endif
     </script>  

     <script>  
function sure(myclass) {
  $(document).on("click", myclass, function(e){
             e.preventDefault();
            //  var link = $(this).attr("href") ?? $(this).attr("action");
             var form =  $(this).closest("form");
             var title = "";
             var text = "";
             var danger = false;
             switch (myclass) {
               case ".approve":
                 title = "Are You Sure Want To Approve This Request?";
                 text = "The Order Will Be Canceled";
                 break;
               case ".refuned":
                 title = "Are You Sure Payment Is Refunded?";
                 break;
               case ".reject":
                 title = "Are You Sure Want To Reject This Request?";
                 danger = true;
                 break;

               case ".cancel":
                 title = "Are You Sure Want To Cancel This Order?";
                 danger = true;
                 break;
               case ".pay":
                 title = "Are You Sure Want To Accept Payment To This Order?";
                 break;
               case ".ship":
                 title = "Are You Sure Want To Start Shipping This Order?";
                 break;
               case ".deliver":
                 title = "Are You Sure This Order Is Delivered?";
                 break;
             
               default:
                 title = "Are You Sure Want To Delete This Item?";
                 danger = true;
                 break;
             }

                swal({
                  title:  title,
                  text: text,
                  icon: "warning",
                  buttons: true,
                  dangerMode: danger,
                })
                .then((willDelete) => {
                  if (willDelete) {
                      //  window.location.href = link;
                      var formaction = $(this).attr('formaction')
                      if (formaction) {
                        form.attr('action', formaction)
                      }
                      form.submit();
                  }
                });
            });
}
sure(".delete");

sure(".approve");
sure(".refuned");
sure(".reject");

sure(".cancel");
sure(".pay");
sure(".ship");
sure(".deliver");
    </script>

    
  </body>
</html>
